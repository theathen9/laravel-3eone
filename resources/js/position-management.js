import { apiFetch } from "./api";

async function readResponse(response) {
    const data = await response.json();

    if (!response.ok || data.success === false) {
        const validationErrors = Object.values(data.errors || {}).flat();
        throw new Error(validationErrors.join(" ") || data.message || "The position request failed.");
    }

    return data;
}

export function setupPositionManagement() {
    const editDialog = document.getElementById("positionEditDialog");

    if (!editDialog) {
        return;
    }

    const editForm = document.getElementById("positionEditForm");
    const editMessage = document.getElementById("positionEditMessage");
    const saveButton = document.getElementById("savePositionEdit");
    const detailDialog = document.getElementById("positionDetailDialog");
    let endpoint = null;
    let method = "PATCH";

    function showEditMessage(text, isError = false) {
        editMessage.textContent = text;
        editMessage.className = isError
            ? "rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700"
            : "rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700";
        editMessage.classList.remove("hidden");
    }

    function setFormDisabled(disabled) {
        editForm.querySelectorAll("input, textarea, select, button[type='submit']").forEach((field) => {
            field.disabled = disabled;
        });
    }

    document.addEventListener("click", (event) => {
        const button = event.target.closest(".position-create");
        if (button) {
            endpoint = button.dataset.endpoint;
            method = "POST";
            editForm.reset();
            editMessage.classList.add("hidden");
            document.getElementById("positionEditTitle").textContent = "Add Position";
            document.getElementById("editPositionStatus").value = "1";
            saveButton.textContent = "Create Position";
            setFormDisabled(false);
            editDialog.showModal();
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".position-edit");
        if (button) {
            endpoint = button.dataset.endpoint;
            method = "PATCH";
            editForm.reset();
            editMessage.classList.add("hidden");
            document.getElementById("positionEditTitle").textContent = "Edit Position";
            saveButton.textContent = "Save Changes";
            editDialog.showModal();
            setFormDisabled(true);
            showEditMessage("Loading position details...");

            try {
                const response = await apiFetch(endpoint);
                const result = await readResponse(response);
                const position = result.data;
                document.getElementById("editPositionCode").value = position.position_code || "";
                document.getElementById("editPositionName").value = position.position_name || "";
                document.getElementById("editPositionDescription").value = position.description || "";
                document.getElementById("editPositionStatus").value = position.status ? "1" : "0";
                editMessage.classList.add("hidden");
            } catch (error) {
                console.error("Could not load position details:", error);
                showEditMessage(error.message || "Could not load position details.", true);
            } finally {
                setFormDisabled(false);
            }
        }
    });

    editForm.addEventListener("submit", async (event) => {
        event.preventDefault();
        editMessage.classList.add("hidden");
        setFormDisabled(true);
        saveButton.textContent = "Saving...";

        const payload = {
            position_code: document.getElementById("editPositionCode").value.trim(),
            position_name: document.getElementById("editPositionName").value.trim(),
            description: document.getElementById("editPositionDescription").value.trim() || null,
            status: document.getElementById("editPositionStatus").value === "1",
        };

        try {
            const response = await apiFetch(endpoint, {
                method,
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(payload),
            });
            const result = await readResponse(response);

            showEditMessage(result.message || "Position saved successfully.");
            window.setTimeout(() => window.location.reload(), 700);
        } catch (error) {
            console.error("Could not save position:", error);
            showEditMessage(error.message || "Could not save position.", true);
            setFormDisabled(false);
        } finally {
            saveButton.textContent = method === "POST" ? "Create Position" : "Save Changes";
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".position-detail");
        if (button) {
            try {
                const response = await apiFetch(button.dataset.endpoint);
                const result = await readResponse(response);
                const position = result.data;

                document.getElementById("positionDetailCode").textContent =
                    position.position_code || `Position #${position.position_id}`;
                document.getElementById("positionDetailName").textContent = position.position_name;
                document.getElementById("positionDetailStatus").textContent =
                    position.status ? "Active" : "Inactive";
                document.getElementById("positionDetailDescription").textContent =
                    position.description || "No description provided";
                detailDialog.showModal();
            } catch (error) {
                console.error("Could not load position details:", error);
                window.alert(error.message || "Could not load position details.");
            }
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".position-delete");
        if (button) {
            if (!window.confirm(`Delete position "${button.dataset.positionName}"?`)) {
                return;
            }

            button.disabled = true;

            try {
                const response = await apiFetch(button.dataset.endpoint, {
                    method: "DELETE",
                });
                await readResponse(response);
                window.location.reload();
            } catch (error) {
                console.error("Could not delete position:", error);
                window.alert(error.message || "Could not delete position.");
                button.disabled = false;
            }
        }
    });

    document.getElementById("closePositionEdit").addEventListener("click", () => editDialog.close());
    document.getElementById("cancelPositionEdit").addEventListener("click", () => editDialog.close());
    document.getElementById("closePositionDetail").addEventListener("click", () => detailDialog.close());

    [editDialog, detailDialog].forEach((dialog) => {
        dialog.addEventListener("click", (event) => {
            if (event.target === event.currentTarget) {
                dialog.close();
            }
        });
    });
}

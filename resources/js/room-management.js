import { apiFetch } from "./api";

async function readResponse(response) {
    const data = await response.json();

    if (!response.ok || data.success === false) {
        const validationErrors = Object.values(data.errors || {}).flat();
        throw new Error(validationErrors.join(" ") || data.message || "The room request failed.");
    }

    return data;
}

export function setupRoomManagement() {
    const editDialog = document.getElementById("roomEditDialog");

    if (!editDialog) {
        return;
    }

    const editForm = document.getElementById("roomEditForm");
    const editMessage = document.getElementById("roomEditMessage");
    const saveButton = document.getElementById("saveRoomEdit");
    const detailDialog = document.getElementById("roomDetailDialog");
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
        editForm.querySelectorAll("input, select, button[type='submit']").forEach((field) => {
            field.disabled = disabled;
        });
    }

    document.addEventListener("click", (event) => {
        const button = event.target.closest(".room-create");
        if (button) {
            endpoint = button.dataset.endpoint;
            method = "POST";
            editForm.reset();
            editMessage.classList.add("hidden");
            document.getElementById("roomEditTitle").textContent = "Add Room";
            document.getElementById("editRoomStatus").value = "1";
            saveButton.textContent = "Create Room";
            setFormDisabled(false);
            editDialog.showModal();
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".room-edit");
        if (button) {
            endpoint = button.dataset.endpoint;
            method = "PATCH";
            editForm.reset();
            editMessage.classList.add("hidden");
            document.getElementById("roomEditTitle").textContent = "Edit Room";
            saveButton.textContent = "Save Changes";
            editDialog.showModal();
            setFormDisabled(true);
            showEditMessage("Loading room details...");

            try {
                const response = await apiFetch(endpoint);
                const result = await readResponse(response);
                const room = result.data;
                document.getElementById("editRoomName").value = room.room_name || "";
                document.getElementById("editRoomCapacity").value = room.capacity ?? "";
                document.getElementById("editRoomStatus").value = room.status ? "1" : "0";
                editMessage.classList.add("hidden");
            } catch (error) {
                console.error("Could not load room details:", error);
                showEditMessage(error.message || "Could not load room details.", true);
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
            room_name: document.getElementById("editRoomName").value.trim(),
            capacity: Number(document.getElementById("editRoomCapacity").value),
            status: document.getElementById("editRoomStatus").value === "1",
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

            showEditMessage(result.message || "Room saved successfully.");
            window.setTimeout(() => window.location.reload(), 700);
        } catch (error) {
            console.error("Could not save room:", error);
            showEditMessage(error.message || "Could not save room.", true);
            setFormDisabled(false);
        } finally {
            saveButton.textContent = method === "POST" ? "Create Room" : "Save Changes";
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".room-detail");
        if (button) {
            try {
                const response = await apiFetch(button.dataset.endpoint);
                const result = await readResponse(response);
                const room = result.data;

                document.getElementById("roomDetailId").textContent = `Room #${room.room_id}`;
                document.getElementById("roomDetailName").textContent = room.room_name;
                document.getElementById("roomDetailCapacity").textContent = `${room.capacity} seats`;
                document.getElementById("roomDetailStatus").textContent = room.status ? "Active" : "Inactive";
                detailDialog.showModal();
            } catch (error) {
                console.error("Could not load room details:", error);
                window.alert(error.message || "Could not load room details.");
            }
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".room-delete");
        if (button) {
            if (!window.confirm(`Delete room "${button.dataset.roomName}"?`)) {
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
                console.error("Could not delete room:", error);
                window.alert(error.message || "Could not delete room.");
                button.disabled = false;
            }
        }
    });

    document.getElementById("closeRoomEdit").addEventListener("click", () => editDialog.close());
    document.getElementById("cancelRoomEdit").addEventListener("click", () => editDialog.close());
    document.getElementById("closeRoomDetail").addEventListener("click", () => detailDialog.close());

    [editDialog, detailDialog].forEach((dialog) => {
        dialog.addEventListener("click", (event) => {
            if (event.target === event.currentTarget) {
                dialog.close();
            }
        });
    });
}

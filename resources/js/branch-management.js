import { apiFetch } from "./api";

export function setupBranchManagement() {
    const dialog = document.getElementById("branchEditDialog");

    if (!dialog) {
        return;
    }

    const form = document.getElementById("branchEditForm");
    const message = document.getElementById("branchEditMessage");
    const saveButton = document.getElementById("saveBranchEdit");
    let endpoint = null;
    let method = "PATCH";

    function showMessage(text, isError = false) {
        message.textContent = text;
        message.className = isError
            ? "rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700"
            : "rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700";
        message.classList.remove("hidden");
    }

    function setFormDisabled(disabled) {
        form.querySelectorAll("input, textarea, select, button[type='submit']").forEach((field) => {
            field.disabled = disabled;
        });
    }

    async function readResponse(response) {
        const data = await response.json();

        if (!response.ok || data.success === false) {
            const validationErrors = Object.values(data.errors || {}).flat();
            throw new Error(validationErrors.join(" ") || data.message || "The branch request failed.");
        }

        return data;
    }

    function populateForm(branch) {
        document.getElementById("editBranchCode").value = branch.branch_code || "";
        document.getElementById("editBranchName").value = branch.branch_name || "";
        document.getElementById("editBranchEmail").value = branch.email || "";
        document.getElementById("editBranchAddress").value = branch.address || "";
        document.getElementById("editBranchLocation").value = branch.location || "";
        document.getElementById("editBranchStatus").value = branch.status ? "1" : "0";

        const phones = branch.phones || [];
        document.getElementById("editMainPhone").value =
            phones.find((phone) => phone.label === "Main")?.number || "";
        document.getElementById("editAlternatePhone").value =
            phones.find((phone) => phone.label === "Alternate")?.number || "";
    }

    function renderHistory(records) {
        const container = document.getElementById("branchDetailHistory");
        container.replaceChildren();

        if (!Array.isArray(records) || records.length === 0) {
            const emptyMessage = document.createElement("p");
            emptyMessage.className = "text-sm text-slate-500";
            emptyMessage.textContent = "No branch history recorded.";
            container.append(emptyMessage);
            return;
        }

        records.forEach((record) => {
            const item = document.createElement("article");
            item.className = "rounded-lg border border-slate-200 bg-slate-50 p-3";

            const title = document.createElement("p");
            title.className = "text-sm font-semibold text-slate-800";
            title.textContent = {
                baseline: "Initial snapshot",
                created: "Branch created",
                updated: "Branch updated",
                deleted: "Branch deleted",
            }[record.action] || "Branch snapshot";
            item.append(title);

            const details = [
                `${record.branch_code} · ${record.branch_name}`,
                record.address,
                record.location,
                record.email,
                Array.isArray(record.phones)
                    ? record.phones.map((phone) => `${phone.number} (${phone.label})`).join(", ")
                    : null,
                record.status ? "Active" : "Inactive",
                record.recorded_at ? new Date(record.recorded_at).toLocaleString() : null,
            ].filter(Boolean);

            const description = document.createElement("p");
            description.className = "mt-1 break-words text-xs text-slate-500";
            description.textContent = details.join(" · ");
            item.append(description);
            container.append(item);
        });
    }

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".branch-detail");
        if (!button) {
            return;
        }

        try {
            const response = await apiFetch(button.dataset.endpoint);
            const result = await readResponse(response);
            const branch = result.data;
            const fields = {
                branch_code: "branchDetailCode",
                branch_name: "branchDetailName",
                email: "branchDetailEmail",
                address: "branchDetailAddress",
                location: "branchDetailLocation",
            };

            Object.entries(fields).forEach(([field, elementId]) => {
                document.getElementById(elementId).textContent =
                    branch[field] || "Not provided";
            });
            document.getElementById("branchDetailStatus").textContent =
                branch.status ? "Active" : "Inactive";

            const phoneContainer = document.getElementById("branchDetailPhones");
            phoneContainer.replaceChildren();
            if (!Array.isArray(branch.phones) || branch.phones.length === 0) {
                phoneContainer.textContent = "Not provided";
            } else {
                branch.phones.forEach((phone) => {
                    const item = document.createElement("p");
                    item.textContent = `${phone.number} (${phone.label})`;
                    phoneContainer.append(item);
                });
            }

            renderHistory(branch.histories);
            document.getElementById("branchDetailDialog").showModal();
        } catch (error) {
            console.error("Could not load branch history:", error);
            window.alert(error.message || "Could not load branch details.");
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".branch-edit");
        if (button) {
            endpoint = button.dataset.endpoint;
            method = "PATCH";
            document.getElementById("branchEditTitle").textContent = "Edit Branch";
            saveButton.textContent = "Save Changes";
            message.classList.add("hidden");
            form.reset();
            dialog.showModal();
            setFormDisabled(true);
            showMessage("Loading branch details...");

            try {
                const response = await apiFetch(endpoint);
                const data = await readResponse(response);
                populateForm(data.data);
                message.classList.add("hidden");
            } catch (error) {
                console.error("Could not load branch details:", error);
                showMessage(error.message || "Could not load branch details.", true);
            } finally {
                setFormDisabled(false);
            }
        }
    });

    document.addEventListener("click", (event) => {
        const button = event.target.closest(".branch-create");
        if (button) {
            endpoint = button.dataset.endpoint;
            method = "POST";
            form.reset();
            message.classList.add("hidden");
            document.getElementById("branchEditTitle").textContent = "Add Branch";
            document.getElementById("editBranchStatus").value = "1";
            saveButton.textContent = "Create Branch";
            setFormDisabled(false);
            dialog.showModal();
        }
    });

    form.addEventListener("submit", async (event) => {
        event.preventDefault();
        message.classList.add("hidden");

        const phones = [
            {
                number: document.getElementById("editMainPhone").value.trim(),
                label: "Main",
            },
            {
                number: document.getElementById("editAlternatePhone").value.trim(),
                label: "Alternate",
            },
        ].filter((phone) => phone.number !== "");

        const payload = {
            branch_code: document.getElementById("editBranchCode").value.trim(),
            branch_name: document.getElementById("editBranchName").value.trim(),
            phones,
            email: document.getElementById("editBranchEmail").value.trim() || null,
            address: document.getElementById("editBranchAddress").value.trim() || null,
            location: document.getElementById("editBranchLocation").value.trim() || null,
            status: document.getElementById("editBranchStatus").value === "1",
        };

        setFormDisabled(true);
        saveButton.textContent = "Saving...";

        try {
            const response = await apiFetch(endpoint, {
                method,
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(payload),
            });
            const data = await readResponse(response);

            showMessage(data.message || "Branch updated successfully.");
            window.setTimeout(() => window.location.reload(), 700);
        } catch (error) {
            console.error("Could not update branch:", error);
            showMessage(error.message || "Could not update branch.", true);
            setFormDisabled(false);
        } finally {
            saveButton.textContent = method === "POST" ? "Create Branch" : "Save Changes";
        }
    });

    document.getElementById("closeBranchEdit").addEventListener("click", () => dialog.close());
    document.getElementById("cancelBranchEdit").addEventListener("click", () => dialog.close());
    dialog.addEventListener("click", (event) => {
        if (event.target === event.currentTarget) {
            dialog.close();
        }
    });
}

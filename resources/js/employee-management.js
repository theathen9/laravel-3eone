import { apiFetch } from "./api";

async function readResponse(response) {
    const data = await response.json();

    if (!response.ok || data.success === false) {
        const validationErrors = Object.values(data.errors || {}).flat();
        throw new Error(validationErrors.join(" ") || data.message || "The employee request failed.");
    }

    return data;
}

function dateInputValue(value) {
    return value ? String(value).slice(0, 10) : "";
}

function isActive(status) {
    return status === true ||
        status === 1 ||
        status === "1" ||
        (typeof status === "string" && status.toLowerCase() === "active");
}

export function setupEmployeeManagement() {
    const editDialog = document.getElementById("employeeEditDialog");

    if (!editDialog) {
        return;
    }

    const editForm = document.getElementById("employeeEditForm");
    const editMessage = document.getElementById("employeeEditMessage");
    const saveButton = document.getElementById("saveEmployeeEdit");
    const detailDialog = document.getElementById("employeeDetailDialog");
    const signatureInput = document.getElementById("editEmployeeSignatureImage");
    const signaturePreview = document.getElementById("editEmployeeSignaturePreview");
    const signatureEmpty = document.getElementById("editEmployeeSignatureEmpty");
    let endpoint = null;
    let employee = null;
    let signatureObjectUrl = null;

    function clearSignaturePreview() {
        if (signatureObjectUrl) {
            URL.revokeObjectURL(signatureObjectUrl);
            signatureObjectUrl = null;
        }

        signaturePreview.removeAttribute("src");
        signaturePreview.classList.add("hidden");
        signatureEmpty.classList.remove("hidden");
    }

    function setSignaturePreview(path) {
        clearSignaturePreview();

        if (!path) {
            return;
        }

        const storageBase = signaturePreview.dataset.storageBase.replace(/\/$/, "");
        const encodedPath = path.split("/").map(encodeURIComponent).join("/");
        signaturePreview.src = `${storageBase}/${encodedPath}`;
        signaturePreview.classList.remove("hidden");
        signatureEmpty.classList.add("hidden");
    }

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

    function fillPositionOptions(positions, selectedPositionId) {
        const select = document.getElementById("editEmployeePosition");
        select.replaceChildren(new Option("Not assigned", ""));

        positions.forEach((position) => {
            select.add(new Option(position.position_name, String(position.position_id)));
        });

        if (
            selectedPositionId &&
            !positions.some((position) => String(position.position_id) === String(selectedPositionId))
        ) {
            select.add(new Option(`Position #${selectedPositionId}`, String(selectedPositionId)));
        }

        select.value = selectedPositionId ? String(selectedPositionId) : "";
    }

    function fillBranchOptions(branches, selectedBranchId) {
        const select = document.getElementById("editEmployeeBranch");
        select.replaceChildren(new Option("Not assigned", ""));

        branches.forEach((branch) => {
            select.add(
                new Option(
                    `${branch.branch_name} (${branch.branch_code})`,
                    String(branch.branch_id),
                ),
            );
        });

        if (
            selectedBranchId &&
            !branches.some((branch) => String(branch.branch_id) === String(selectedBranchId))
        ) {
            select.add(new Option(`Branch #${selectedBranchId}`, String(selectedBranchId)));
        }

        select.value = selectedBranchId ? String(selectedBranchId) : "";
    }

    function renderPositionHistory(history, currentPositionId) {
        const container = document.getElementById("employeeDetailPositionHistory");
        container.replaceChildren();

        const records = Array.isArray(history) ? [...history] : [];
        records.sort((a, b) =>
            dateInputValue(b.start_date).localeCompare(dateInputValue(a.start_date)),
        );

        if (records.length === 0) {
            const emptyMessage = document.createElement("p");
            emptyMessage.className = "text-sm text-gray-500";
            emptyMessage.textContent = "No position history recorded.";
            container.append(emptyMessage);
            return;
        }

        records.forEach((record) => {
            const isCurrent =
                !record.end_date &&
                String(record.position_id) === String(currentPositionId);
            const positionName =
                record.position?.position_name || `Position #${record.position_id}`;
            const positionTitle = record.position?.position_code
                ? `${positionName} · ${record.position.position_code}`
                : positionName;
            const periodEnd = record.end_date
                ? dateInputValue(record.end_date)
                : isCurrent
                  ? "Present"
                  : "End date not recorded";

            const item = document.createElement("article");
            item.className =
                "flex flex-col gap-2 rounded-lg border border-gray-200 bg-white p-3 sm:flex-row sm:items-start sm:justify-between";

            const details = document.createElement("div");
            details.className = "min-w-0";

            const title = document.createElement("p");
            title.className = "text-sm font-semibold text-gray-800";
            title.textContent = positionTitle;
            details.append(title);

            const metadata = [
                `${dateInputValue(record.start_date) || "Start date not recorded"} – ${periodEnd}`,
                record.department?.department_name,
                record.remarks,
            ].filter(Boolean);

            if (metadata.length > 0) {
                const description = document.createElement("p");
                description.className = "mt-1 whitespace-pre-line text-xs text-gray-500";
                description.textContent = metadata.join(" · ");
                details.append(description);
            }

            const badge = document.createElement("span");
            badge.className = isCurrent
                ? "inline-flex w-fit shrink-0 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700"
                : "inline-flex w-fit shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600";
            badge.textContent = isCurrent ? "Current" : "History";

            item.append(details, badge);
            container.append(item);
        });
    }

    function renderBranchHistory(history, currentBranchId) {
        const container = document.getElementById("employeeDetailBranchHistory");
        container.replaceChildren();

        const records = Array.isArray(history) ? [...history] : [];
        records.sort((a, b) =>
            dateInputValue(b.start_date).localeCompare(dateInputValue(a.start_date)),
        );

        if (records.length === 0) {
            const emptyMessage = document.createElement("p");
            emptyMessage.className = "text-sm text-gray-500";
            emptyMessage.textContent = "No branch history recorded.";
            container.append(emptyMessage);
            return;
        }

        records.forEach((record) => {
            const isCurrent =
                !record.end_date &&
                String(record.branch_id) === String(currentBranchId);
            const item = document.createElement("article");
            item.className =
                "flex flex-col gap-2 rounded-lg border border-gray-200 bg-white p-3 sm:flex-row sm:items-start sm:justify-between";

            const details = document.createElement("div");
            details.className = "min-w-0";

            const title = document.createElement("p");
            title.className = "text-sm font-semibold text-gray-800";
            title.textContent = `${record.branch_code} · ${record.branch_name}`;
            details.append(title);

            const endDate = record.end_date
                ? dateInputValue(record.end_date)
                : isCurrent
                  ? "Present"
                  : "End date not recorded";
            const metadata = [
                `${dateInputValue(record.start_date) || "Start date not recorded"} – ${endDate}`,
                record.remarks,
            ].filter(Boolean);
            const description = document.createElement("p");
            description.className = "mt-1 break-words whitespace-pre-line text-xs text-gray-500";
            description.textContent = metadata.join(" · ");
            details.append(description);

            const badge = document.createElement("span");
            badge.className = isCurrent
                ? "inline-flex w-fit shrink-0 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700"
                : "inline-flex w-fit shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600";
            badge.textContent = isCurrent ? "Current" : "History";

            item.append(details, badge);
            container.append(item);
        });
    }

    function populateEditForm(data, positions, branches) {
        employee = data;
        document.getElementById("editFirstNameEn").value = data.first_name_en || "";
        document.getElementById("editLastNameEn").value = data.last_name_en || "";
        document.getElementById("editFirstNameKh").value = data.first_name_kh || "";
        document.getElementById("editLastNameKh").value = data.last_name_kh || "";
        document.getElementById("editEmployeeGender").value = data.gender || "Male";
        document.getElementById("editEmployeeDob").value = dateInputValue(data.dob);
        document.getElementById("editEmployeePhone1").value = data.phone1 || "";
        document.getElementById("editEmployeePhone2").value = data.phone2 || "";
        document.getElementById("editEmployeeEmail").value = data.email || "";
        document.getElementById("editEmployeeHiredAt").value = dateInputValue(data.hired_at);
        document.getElementById("editEmployeeStatus").value = isActive(data.status) ? "1" : "0";
        setSignaturePreview(data.signature_image);
        fillPositionOptions(positions, data.position_id);
        fillBranchOptions(branches, data.branch_id);
    }

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".employee-edit");
        if (button) {
            endpoint = button.dataset.endpoint;
            employee = null;
            editForm.reset();
            clearSignaturePreview();
            editMessage.classList.add("hidden");
            editDialog.showModal();
            setFormDisabled(true);
            showEditMessage("Loading employee details...");

            try {
                const [employeeResponse, positionsResponse, branchesResponse] = await Promise.all([
                    apiFetch(endpoint),
                    apiFetch(button.dataset.positionsEndpoint),
                    apiFetch(button.dataset.branchesEndpoint),
                ]);
                const [employeeResult, positionsResult, branchesResult] = await Promise.all([
                    readResponse(employeeResponse),
                    readResponse(positionsResponse),
                    readResponse(branchesResponse),
                ]);

                populateEditForm(
                    employeeResult.data,
                    positionsResult.data,
                    branchesResult.data,
                );
                editMessage.classList.add("hidden");
            } catch (error) {
                console.error("Could not load employee details:", error);
                showEditMessage(error.message || "Could not load employee details.", true);
            } finally {
                setFormDisabled(false);
            }
        }
    });

    signatureInput.addEventListener("change", () => {
        const file = signatureInput.files?.[0];

        if (!file) {
            setSignaturePreview(employee?.signature_image);
            return;
        }

        clearSignaturePreview();
        signatureObjectUrl = URL.createObjectURL(file);
        signaturePreview.src = signatureObjectUrl;
        signaturePreview.classList.remove("hidden");
        signatureEmpty.classList.add("hidden");
    });

    editForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        if (!employee) {
            showEditMessage("Employee details are not loaded.", true);
            return;
        }

        editMessage.classList.add("hidden");
        setFormDisabled(true);
        saveButton.textContent = "Saving...";

        const payload = {
            employee_id: employee.employee_id,
            first_name_en: document.getElementById("editFirstNameEn").value.trim(),
            last_name_en: document.getElementById("editLastNameEn").value.trim(),
            first_name_kh: document.getElementById("editFirstNameKh").value.trim(),
            last_name_kh: document.getElementById("editLastNameKh").value.trim(),
            gender: document.getElementById("editEmployeeGender").value,
            dob: document.getElementById("editEmployeeDob").value,
            phone1: document.getElementById("editEmployeePhone1").value.trim(),
            phone2: document.getElementById("editEmployeePhone2").value.trim() || null,
            email: document.getElementById("editEmployeeEmail").value.trim() || null,
            position_id: document.getElementById("editEmployeePosition").value || null,
            branch_id: document.getElementById("editEmployeeBranch").value || null,
            hired_at: document.getElementById("editEmployeeHiredAt").value,
            status: document.getElementById("editEmployeeStatus").value === "1",
            birth_addr_province: employee.birth_addr_province,
            birth_addr_district: employee.birth_addr_district,
            birth_addr_commune: employee.birth_addr_commune,
            birth_addr_village: employee.birth_addr_village,
            curr_addr_province: employee.curr_addr_province,
            curr_addr_district: employee.curr_addr_district,
            curr_addr_commune: employee.curr_addr_commune,
            curr_addr_village: employee.curr_addr_village,
        };

        const formData = new FormData();
        Object.entries(payload).forEach(([key, value]) => {
            const formValue = key === "status"
                ? (value ? "1" : "0")
                : value === null
                    ? ""
                    : String(value);
            formData.append(key, formValue);
        });
        formData.append("_method", "PATCH");

        const signatureFile = signatureInput.files?.[0];
        if (signatureFile) {
            formData.append("signature_image", signatureFile);
        }

        try {
            const response = await apiFetch(endpoint, {
                method: "POST",
                headers: {
                    Accept: "application/json",
                },
                body: formData,
            });
            const result = await readResponse(response);

            showEditMessage(result.message || "Employee updated successfully.");
            window.setTimeout(() => window.location.reload(), 700);
        } catch (error) {
            console.error("Could not update employee:", error);
            showEditMessage(error.message || "Could not update employee.", true);
            setFormDisabled(false);
        } finally {
            saveButton.textContent = "Save Changes";
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".employee-detail");
        if (button) {
            try {
                const response = await apiFetch(button.dataset.endpoint);
                const result = await readResponse(response);
                const data = result.data;
                const englishName = `${data.first_name_en || ""} ${data.last_name_en || ""}`.trim();
                const khmerName = `${data.first_name_kh || ""} ${data.last_name_kh || ""}`.trim();

                document.getElementById("employeeDetailId").textContent = `Employee #${data.employee_id}`;
                document.getElementById("employeeDetailCode").textContent = data.employee_code || "Not assigned";
                document.getElementById("employeeDetailName").textContent = englishName || "Unnamed Employee";
                document.getElementById("employeeDetailKhmerName").textContent = khmerName;
                document.getElementById("employeeDetailGender").textContent = data.gender || "Not provided";
                document.getElementById("employeeDetailDob").textContent = dateInputValue(data.dob) || "Not provided";
                document.getElementById("employeeDetailPosition").textContent =
                    data.position?.position_name || "Not assigned";
                document.getElementById("employeeDetailBranchCode").textContent =
                    data.branch?.branch_code || "Not assigned";
                document.getElementById("employeeDetailStatus").textContent = isActive(data.status) ? "Active" : "Inactive";
                document.getElementById("employeeDetailPhone1").textContent = data.phone1 || "Not provided";
                document.getElementById("employeeDetailPhone2").textContent = data.phone2 || "Not provided";
                document.getElementById("employeeDetailEmail").textContent = data.email || "Not provided";
                document.getElementById("employeeDetailHiredAt").textContent = dateInputValue(data.hired_at) || "Not provided";
                renderPositionHistory(
                    data.position_histories || data.positionHistories,
                    data.position_id,
                );
                renderBranchHistory(
                    data.branch_histories || data.branchHistories,
                    data.branch_id,
                );
                detailDialog.showModal();
            } catch (error) {
                console.error("Could not load employee details:", error);
                window.alert(error.message || "Could not load employee details.");
            }
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".employee-delete");
        if (button) {
            if (!window.confirm(
                `Delete ${button.dataset.employeeName}? Associated employee position history may also be deleted.`
            )) {
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
                console.error("Could not delete employee:", error);
                window.alert(error.message || "Could not delete employee.");
                button.disabled = false;
            }
        }
    });

    document.getElementById("closeEmployeeEdit").addEventListener("click", () => editDialog.close());
    document.getElementById("cancelEmployeeEdit").addEventListener("click", () => editDialog.close());
    document.getElementById("closeEmployeeDetail").addEventListener("click", () => detailDialog.close());

    [editDialog, detailDialog].forEach((dialog) => {
        dialog.addEventListener("click", (event) => {
            if (event.target === event.currentTarget) {
                dialog.close();
            }
        });
    });
}

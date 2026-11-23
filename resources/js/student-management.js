import { apiFetch } from "./api";

async function readResponse(response) {
    const data = await response.json();

    if (!response.ok || data.success === false) {
        const validationErrors = Object.values(data.errors || {}).flat();
        throw new Error(validationErrors.join(" ") || data.message || "The student request failed.");
    }

    return data;
}

function dateInputValue(value) {
    return value ? String(value).slice(0, 10) : "";
}

function statusValue(status) {
    const value = String(status || "").toLowerCase();

    if (value === "1" || value === "active") {
        return "active";
    }
    if (value === "0" || value === "inactive") {
        return "inactive";
    }
    return "draft";
}

export function setupStudentManagement() {
    const editDialog = document.getElementById("studentEditDialog");

    if (!editDialog) {
        return;
    }

    const editForm = document.getElementById("studentEditForm");
    const editMessage = document.getElementById("studentEditMessage");
    const saveButton = document.getElementById("saveStudentEdit");
    let updateEndpoint = null;
    let student = null;

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

    function populateEditForm(data) {
        student = data;
        document.getElementById("editStudentFirstNameEn").value = data.first_name_en || "";
        document.getElementById("editStudentLastNameEn").value = data.last_name_en || "";
        document.getElementById("editStudentFirstNameKh").value = data.first_name_kh || "";
        document.getElementById("editStudentLastNameKh").value = data.last_name_kh || "";
        document.getElementById("editStudentGender").value =
            String(data.gender || "Male").toLowerCase() === "female" ? "Female" : "Male";
        document.getElementById("editStudentDob").value = dateInputValue(data.dob);
        document.getElementById("editStudentPhone1").value = data.phone1 || "";
        document.getElementById("editStudentPhone2").value = data.phone2 || "";
        document.getElementById("editStudentEmail").value = data.email || "";
        document.getElementById("editStudentAcademicYear").value = data.academic_year || "";
        document.getElementById("editStudentRegisterAt").value = dateInputValue(data.register_at);
        document.getElementById("editStudentStatus").value = statusValue(data.status);
        document.getElementById("editStudentGuardian1Name").value = data.guardian1_name || "";
        document.getElementById("editStudentGuardian1Relationship").value = data.guardian1_relationship || "";
        document.getElementById("editStudentGuardian1Phone").value = data.guardian1_phone || "";
        document.getElementById("editStudentGuardian2Name").value = data.guardian2_name || "";
        document.getElementById("editStudentGuardian2Relationship").value = data.guardian2_relationship || "";
        document.getElementById("editStudentGuardian2Phone").value = data.guardian2_phone || "";
        document.getElementById("editStudentGuardianEmail").value = data.guardian_email || "";
    }

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".student-edit");
        if (button) {
            updateEndpoint = button.dataset.updateEndpoint;
            student = null;
            editForm.reset();
            editMessage.classList.add("hidden");
            editDialog.showModal();
            setFormDisabled(true);
            showEditMessage("Loading student details...");

            try {
                const response = await apiFetch(button.dataset.endpoint);
                const result = await readResponse(response);
                populateEditForm(result.data);
                editMessage.classList.add("hidden");
            } catch (error) {
                console.error("Could not load student details:", error);
                showEditMessage(error.message || "Could not load student details.", true);
            } finally {
                setFormDisabled(false);
            }
        }
    });

    editForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        if (!student || !updateEndpoint) {
            showEditMessage("Student details are not loaded.", true);
            return;
        }

        editMessage.classList.add("hidden");
        setFormDisabled(true);
        saveButton.textContent = "Saving...";

        const payload = {
            student_code: student.student_code,
            first_name_en: document.getElementById("editStudentFirstNameEn").value.trim(),
            last_name_en: document.getElementById("editStudentLastNameEn").value.trim(),
            first_name_kh: document.getElementById("editStudentFirstNameKh").value.trim(),
            last_name_kh: document.getElementById("editStudentLastNameKh").value.trim(),
            gender: document.getElementById("editStudentGender").value,
            dob: document.getElementById("editStudentDob").value,
            phone1: document.getElementById("editStudentPhone1").value.trim(),
            phone2: document.getElementById("editStudentPhone2").value.trim() || null,
            email: document.getElementById("editStudentEmail").value.trim() || null,
            academic_year: document.getElementById("editStudentAcademicYear").value.trim(),
            register_at: document.getElementById("editStudentRegisterAt").value || null,
            status: document.getElementById("editStudentStatus").value,
            guardian1_name: document.getElementById("editStudentGuardian1Name").value.trim(),
            guardian1_relationship: document.getElementById("editStudentGuardian1Relationship").value.trim(),
            guardian1_phone: document.getElementById("editStudentGuardian1Phone").value.trim() || null,
            guardian2_name: document.getElementById("editStudentGuardian2Name").value.trim(),
            guardian2_relationship: document.getElementById("editStudentGuardian2Relationship").value.trim(),
            guardian2_phone: document.getElementById("editStudentGuardian2Phone").value.trim() || null,
            guardian_email: document.getElementById("editStudentGuardianEmail").value.trim() || null,
        };

        try {
            const response = await apiFetch(updateEndpoint, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(payload),
            });
            const result = await readResponse(response);

            showEditMessage(result.message || "Student updated successfully.");
            window.setTimeout(() => window.location.reload(), 700);
        } catch (error) {
            console.error("Could not update student:", error);
            showEditMessage(error.message || "Could not update student.", true);
            setFormDisabled(false);
        } finally {
            saveButton.textContent = "Save Changes";
        }
    });

    document.addEventListener("click", async (event) => {
        const button = event.target.closest(".student-delete");
        if (button) {
            const name = button.dataset.studentName || "this student";

            if (!window.confirm(
                `Delete ${name}? Students with enrollment, invoice, or academic records cannot be deleted.`
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
                console.error("Could not delete student:", error);
                window.alert(error.message || "Could not delete student.");
                button.disabled = false;
            }
        }
    });

    document.getElementById("closeStudentEdit").addEventListener("click", () => editDialog.close());
    document.getElementById("cancelStudentEdit").addEventListener("click", () => editDialog.close());

    editDialog.addEventListener("click", (event) => {
        if (event.target === event.currentTarget) {
            editDialog.close();
        }
    });
}

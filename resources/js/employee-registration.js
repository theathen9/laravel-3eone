// ============================================================
// resources/js/employee-registration.js
// ============================================================

import { apiFetch } from "./api";

const employeeRegistration = {
    isSaving: false,
    elements: {},
    profileObjectUrl: null,
    lastInvoiceId: null,

    showMessage(message, type = "success") {
        const box = document.getElementById("registrationMessage");

        if (!box) {
            alert(message);
            return;
        }

        box.className = `alert alert-${type} alert-dismissible fade show`;
        box.setAttribute("role", "alert");
        box.replaceChildren();

        const text = document.createElement("span");
        text.textContent = message;
        box.appendChild(text);

        const close = document.createElement("button");
        close.type = "button";
        close.className = "btn-close";
        close.setAttribute("data-bs-dismiss", "alert");
        close.setAttribute("aria-label", "Close");

        box.appendChild(close);

        box.scrollIntoView({
            behavior: "smooth",
            block: "center",
        });
    },

    showError(message) {
        this.showMessage(message, "danger");
    },

    init() {
        this.elements = {
            form: document.getElementById("employeeRegistration"),
            finalSubmit: document.getElementById("finalSubmit"),
            profilePreview: document.getElementById("preview_profile_image"),
            profileInput: document.getElementById("profile_image"),
        };

        const { form, profileInput } = this.elements;

        if (!form) {
            console.error("Employee registration form not found.");
            return;
        }

        form.addEventListener("submit", (event) => {
            event.preventDefault();
            this.submit();
        });

        profileInput?.addEventListener("change", (event) => {
            this.previewProfileImage(event);
        });
    },

    async autoSave() {
        if (this.isSaving) {
            return;
        }

        this.isSaving = true;

        try {
            const formData = new FormData(this.elements.form);

            const response = await apiFetch("/api/v1/employees", {
                method: "POST",
                body: formData,
                headers: {
                    Accept: "application/json",
                },
            });

            let data;

            try {
                data = await response.json();
            } catch {
                throw new Error(
                    `Invalid server response (HTTP ${response.status}).`,
                );
            }

            if (!response.ok || data.success !== true) {
                throw new Error(
                    data.message ||
                        data.error ||
                        `Registration failed (HTTP ${response.status}).`,
                );
            }

            if (data.invoice_id) {
                this.lastInvoiceId = data.invoice_id;
            }

            return data;
        } finally {
            this.isSaving = false;
        }
    },

    validate() {
        const form = this.elements.form;

        if (!form) {
            return false;
        }

        let valid = true;

        // Validate all required fields, including dynamically shown inputs.
        const inputs = form.querySelectorAll("[required]");

        inputs.forEach((input) => {
            // Ignore disabled controls.
            if (input.disabled) {
                input.classList.remove("is-invalid");
                return;
            }

            // Native validation: required, email, URL, date, etc.
            if (!input.checkValidity()) {
                input.classList.add("is-invalid");
                valid = false;
            } else {
                input.classList.remove("is-invalid");
            }
        });

        if (!valid) {
            const firstInvalid = form.querySelector("[required].is-invalid");

            firstInvalid?.focus();

            firstInvalid?.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });
        }

        return valid;
    },
    // new
    // validate() {
    //     const form = this.elements.form;

    //     if (!form) {
    //         return false;
    //     }

    //     // Clear previous validation states.
    //     form.querySelectorAll(".is-invalid").forEach((field) => {
    //         field.classList.remove("is-invalid");
    //     });

    //     // Validate required fields.
    //     const inputs = form.querySelectorAll(
    //         "input[required], select[required], textarea[required]",
    //     );

    //     const invalidFields = [];

    //     inputs.forEach((input) => {
    //         if (input.disabled) {
    //             return;
    //         }

    //         if (!input.checkValidity()) {
    //             input.classList.add("is-invalid");
    //             invalidFields.push(input);
    //         }
    //     });

    //     if (invalidFields.length > 0) {
    //         const firstInvalid = invalidFields[0];

    //         firstInvalid.focus({ preventScroll: true });

    //         firstInvalid.scrollIntoView({
    //             behavior: "smooth",
    //             block: "center",
    //         });

    //         // Optional: show a message at the top of the form.
    //         this.showError(
    //             `Please complete the required field: ${
    //                 firstInvalid.labels?.[0]?.textContent.trim() ||
    //                 firstInvalid.name ||
    //                 "Please check the highlighted fields."
    //             }`,
    //         );

    //         return false;
    //     }

    //     return true;
    // },

    async submit() {
        if (this.isSaving) {
            return;
        }

        // Validate before sending data to the API.
        if (!this.validate()) {
            return;
        }

        const button = this.elements.finalSubmit;

        if (button) {
            button.disabled = true;
        }

        try {
            const data = await this.autoSave();

            if (!data?.success) {
                throw new Error(
                    data?.message || "Employee registration failed.",
                );
            }

            this.showMessage(
                data.message || "Employee registered successfully!",
                "success",
            );

            // Optional: reset the form after successful registration.
            // this.elements.form.reset();

            // Optional: redirect after successful registration.
            setTimeout(() => {
                window.location.href = "/admin/registrations/employees";
            }, 1000);
        } catch (error) {
            console.error("Employee registration error:", error);

            this.showError(error.message || "Unable to register employee.");
        } finally {
            if (button) {
                button.disabled = false;
            }
        }
    },

    previewProfileImage(event) {
        const file = event.target.files?.[0];
        const preview = this.elements.profilePreview;

        if (!file || !preview) {
            return;
        }

        if (!file.type.startsWith("image/")) {
            this.showError("Please select an image file.");
            event.target.value = "";
            return;
        }

        if (this.profileObjectUrl) {
            URL.revokeObjectURL(this.profileObjectUrl);
        }

        this.profileObjectUrl = URL.createObjectURL(file);
        preview.src = this.profileObjectUrl;
    },
};

document.addEventListener("DOMContentLoaded", () => {
    employeeRegistration.init();
});

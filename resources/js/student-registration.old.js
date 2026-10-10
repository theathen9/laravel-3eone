// ============================================================
// /resources\js\process-register.js
// ============================================================
import { apiFetch } from "./api";

const StudentRegistration = {
    currentStep: 0,
    steps: [],
    isSaving: false,
    progressBar: null,

    selectedClasses: [],
    lastInvoiceId: null,

    elements: {},

    init() {
        this.steps = Array.from(document.querySelectorAll(".step"));

        if (!this.steps.length) {
            return;
        }

        this.progressBar = document.getElementById("stepProgressBar");

        this.elements = {
            form: document.getElementById("studentForm"),
            stepInput: document.getElementById("stepInput"),

            classSelect: document.getElementById("classSelect"),
            addClassBtn: document.getElementById("addClassBtn"),
            tableBody: document.querySelector("#classTable tbody"),

            totalInput: document.getElementById("totalInput"),
            discountInput: document.getElementById("discount"),
            paidInput: document.getElementById("paid"),

            finalTotal: document.getElementById("finalTotal"),
            balance: document.getElementById("balance"),
            classSummary: document.getElementById("classSummary"),

            finalSubmit: document.getElementById("finalSubmit"),

            profileImage: document.getElementById("profile_image"),
            profilePreview: document.getElementById("preview_profile_image"),
        };

        this.bindEvents();
        this.loadClasses();

        this.showStep(0);
        this.calculate();
    },

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

    // =========================================================
    // EVENTS
    // =========================================================

    bindEvents() {
        document.addEventListener("click", async (event) => {
            const nextButton = event.target.closest(".next-step");
            const prevButton = event.target.closest(".prev-step");
            const removeButton = event.target.closest(".remove-class");

            if (nextButton) {
                await this.next();
                return;
            }

            if (prevButton) {
                this.prev();
                return;
            }

            if (removeButton) {
                this.removeClass(removeButton.dataset.id);
            }
        });

        this.elements.addClassBtn?.addEventListener("click", () => {
            this.addClass();
        });

        this.elements.discountInput?.addEventListener("input", () => {
            this.calculate();
        });

        this.elements.paidInput?.addEventListener("input", () => {
            this.calculate();
        });

        this.elements.finalSubmit?.addEventListener("click", async () => {
            await this.submit();
        });

        this.elements.profileImage?.addEventListener("change", (event) => {
            this.previewProfileImage(event);
        });

        // Remove invalid state when user changes an input.
        this.elements.form?.addEventListener("input", (event) => {
            if (event.target.classList.contains("is-invalid")) {
                event.target.classList.remove("is-invalid");
            }
        });

        this.elements.form?.addEventListener("change", (event) => {
            if (event.target.classList.contains("is-invalid")) {
                event.target.classList.remove("is-invalid");
            }
        });
    },

    // =========================================================
    // STEP NAVIGATION
    // =========================================================

    getCurrentStep() {
        return this.steps[this.currentStep];
    },

    validateCurrentStep() {
        const step = this.getCurrentStep();

        if (!step) {
            return false;
        }

        const inputs = step.querySelectorAll("[required]");

        let valid = true;

        inputs.forEach((input) => {
            // Disabled fields are intentionally ignored.
            if (input.disabled) {
                return;
            }

            let value = input.value;

            if (typeof value === "string") {
                value = value.trim();
            }

            if (!value) {
                input.classList.add("is-invalid");
                valid = false;
            } else {
                input.classList.remove("is-invalid");
            }
        });

        if (!valid) {
            const firstInvalid = step.querySelector(".is-invalid");

            firstInvalid?.focus();
        }

        return valid;
    },

    async next() {
        if (!this.validateCurrentStep()) {
            return;
        }

        try {
            await this.autoSave();

            if (this.currentStep < this.steps.length - 1) {
                this.currentStep++;

                this.showStep(this.currentStep);
            }
        } catch (error) {
            console.error("Next step failed:", error);
        }
    },

    prev() {
        if (this.currentStep <= 0) {
            return;
        }

        this.currentStep--;

        this.showStep(this.currentStep);
    },

    showStep(index) {
        this.steps.forEach((step, stepIndex) => {
            step.classList.toggle("d-none", stepIndex !== index);
        });

        this.currentStep = index;

        if (this.elements.stepInput) {
            this.elements.stepInput.value = index + 1;
        }

        this.updateProgress();

        // Update payment summary whenever entering step 3.
        if (index === 2) {
            this.updateSummary();
        }
    },

    updateProgress() {
        if (!this.progressBar || !this.steps.length) {
            return;
        }

        const percent = ((this.currentStep + 1) / this.steps.length) * 100;

        this.progressBar.style.width = `${percent}%`;
    },

    // =========================================================
    // AUTO SAVE
    // =========================================================

    async autoSave() {
        if (this.isSaving) {
            throw new Error("A save request is already in progress.");
        }

        if (!this.elements.form) {
            throw new Error("Student registration form not found.");
        }

        this.isSaving = true;

        try {
            this.updateHiddenInputs();

            const formData = new FormData(this.elements.form);
            formData.set("step", String(this.currentStep + 1));

            const response = await apiFetch(
                "/api/v1/students/register-process",
                {
                    method: "POST",
                    body: formData,
                    headers: {
                        Accept: "application/json",
                    },
                },
            );

            let data;

            try {
                data = await response.json();
            } catch {
                throw new Error(
                    `Invalid server response (HTTP ${response.status}).`,
                );
            }

            if (!response.ok || data?.success !== true) {
                throw new Error(
                    data?.message ||
                        data?.error ||
                        `Unable to save registration (HTTP ${response.status}).`,
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

    // =========================================================
    // CLASS API
    // =========================================================

    async loadClasses() {
        if (!this.elements.classSelect) {
            return;
        }

        try {
            const response = await apiFetch("/api/v1/classes/available", {
                method: "GET",
                headers: {
                    Accept: "application/json",
                },
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || "Unable to load classes.");
            }

            this.elements.classSelect.innerHTML = `
                <option value="">
                    -- Choose Class --
                </option>
            `;

            (data.classes || []).forEach((classItem) => {
                const option = document.createElement("option");

                option.value = classItem.id;

                option.dataset.code = classItem.code ?? "";
                option.dataset.name = classItem.name ?? "";
                option.dataset.course = classItem.course ?? "";
                option.dataset.teacher = classItem.teacher ?? "";
                option.dataset.room = classItem.room ?? "";
                option.dataset.study = classItem.study ?? "";
                option.dataset.time = classItem.time ?? "";
                option.dataset.price = classItem.price ?? 0;

                option.textContent = `${classItem.code ?? ""} - ${classItem.name ?? ""}`;

                this.elements.classSelect.appendChild(option);
            });
        } catch (error) {
            console.error("Load classes error:", error);

            this.showError(error.message || "Unable to load classes.");
        }
    },

    // =========================================================
    // ADD CLASS
    // =========================================================

    addClass() {
        const select = this.elements.classSelect;

        if (!select) {
            return;
        }

        const option = select.selectedOptions[0];

        if (!option || !option.value) {
            alert("Please select a class.");
            return;
        }

        const alreadyExists = this.selectedClasses.some(
            (classItem) => classItem.id === option.value,
        );

        if (alreadyExists) {
            alert("Class already added.");
            return;
        }

        const classData = {
            id: option.value,
            code: option.dataset.code || "",
            name: option.dataset.name || "",
            course: option.dataset.course || "",
            teacher: option.dataset.teacher || "",
            room: option.dataset.room || "",
            study: option.dataset.study || "",
            time: option.dataset.time || "",
            price: Number.parseFloat(option.dataset.price || 0),
        };

        this.selectedClasses.push(classData);

        this.renderClassTable();
        this.updateSummary();
    },

    // =========================================================
    // REMOVE CLASS
    // =========================================================

    removeClass(id) {
        this.selectedClasses = this.selectedClasses.filter(
            (classItem) => classItem.id !== id,
        );

        this.renderClassTable();
        this.updateSummary();
    },

    // =========================================================
    // HIDDEN CLASS INPUTS
    // =========================================================

    updateHiddenInputs() {
        if (!this.elements.form) {
            return;
        }

        this.elements.form
            .querySelectorAll(".class-hidden-input")
            .forEach((input) => input.remove());

        this.selectedClasses.forEach((classItem) => {
            const input = document.createElement("input");

            input.type = "hidden";
            input.name = "class_ids[]";
            input.value = classItem.id;
            input.classList.add("class-hidden-input");

            this.elements.form.appendChild(input);
        });
    },

    // =========================================================
    // CLASS TABLE
    // =========================================================

    // renderClassTable() {
    //     const tbody = this.elements.tableBody;

    //     if (!tbody) {
    //         return;
    //     }

    //     tbody.innerHTML = "";

    //     this.selectedClasses.forEach((classItem) => {
    //         const row = document.createElement("tr");

    //         row.innerHTML = `
    //             <td>${this.escapeHtml(classItem.code)}</td>
    //             <td>${this.escapeHtml(classItem.name)}</td>
    //             <td>${this.escapeHtml(classItem.course)}</td>
    //             <td>${this.escapeHtml(classItem.teacher)}</td>
    //             <td>${this.escapeHtml(classItem.room)}</td>
    //             <td>${this.escapeHtml(classItem.study)}</td>
    //             <td>${this.escapeHtml(classItem.time)}</td>
    //             <td>$${this.formatMoney(classItem.price)}</td>
    //             <td>
    //                 <button
    //                     type="button"
    //                     class="btn btn-danger btn-sm remove-class"
    //                     data-id="${this.escapeHtml(classItem.id)}">
    //                     Remove
    //                 </button>
    //             </td>
    //         `;

    //         tbody.appendChild(row);
    //     });

    //     this.updateHiddenInputs();
    // },

    renderClassTable() {
        const tbody = this.elements.tableBody;

        if (!tbody) {
            return;
        }

        tbody.innerHTML = "";

        this.selectedClasses.forEach((classItem) => {
            const row = document.createElement("tr");

            row.innerHTML = `
            <td>
                ${this.escapeHtml(classItem.code)}
            </td>

            <td>
                ${this.escapeHtml(classItem.course)}
            </td>

            <td>
                ${this.escapeHtml(classItem.teacher || "Not Assigned")}
            </td>

            <td>
                ${this.escapeHtml(classItem.name)}
            </td>

            <td>
                ${this.escapeHtml(classItem.room || "Not Assigned")}
            </td>

            <td>
                ${this.escapeHtml(classItem.study || "Not Set")}
            </td>

            <td>
                ${this.escapeHtml(classItem.time || "Not Set")}
            </td>

            <td>
                $${this.formatMoney(classItem.price)}
            </td>

            <td>
                <button
                    type="button"
                    class="btn btn-danger btn-sm remove-class"
                    data-id="${this.escapeHtml(classItem.id)}">
                    Remove
                </button>
            </td>
        `;

            tbody.appendChild(row);
        });

        this.updateHiddenInputs();
    },

    // =========================================================
    // PAYMENT SUMMARY
    // =========================================================

    updateSummary() {
        const summary = this.elements.classSummary;

        if (!summary) {
            return;
        }

        let total = 0;

        let html = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Class Code</th>
                        <th>Class Name</th>
                        <th>Course</th>
                        <th>Teacher</th>
                        <th>Room</th>
                        <th>Study</th>
                        <th>Time</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
        `;

        if (!this.selectedClasses.length) {
            html += `
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        No classes selected.
                    </td>
                </tr>
            `;
        }

        this.selectedClasses.forEach((classItem) => {
            total += Number(classItem.price || 0);

            html += `
                <tr>
                    <td>${this.escapeHtml(classItem.code)}</td>
                    <td>${this.escapeHtml(classItem.name)}</td>
                    <td>${this.escapeHtml(classItem.course)}</td>
                    <td>${this.escapeHtml(classItem.teacher)}</td>
                    <td>${this.escapeHtml(classItem.room)}</td>
                    <td>${this.escapeHtml(classItem.study)}</td>
                    <td>${this.escapeHtml(classItem.time)}</td>
                    <td>$${this.formatMoney(classItem.price)}</td>
                </tr>
            `;
        });

        html += `
                </tbody>
            </table>
        `;

        summary.innerHTML = html;

        if (this.elements.totalInput) {
            this.elements.totalInput.value = total.toFixed(2);
        }

        this.updateHiddenInputs();

        this.calculate();
    },

    // =========================================================
    // PAYMENT CALCULATION
    // =========================================================

    // calculate() {
    //     const total = Number.parseFloat(this.elements.totalInput?.value || 0);

    //     const discount = Number.parseFloat(
    //         this.elements.discountInput?.value || 0,
    //     );

    //     const paid = Number.parseFloat(this.elements.paidInput?.value || 0);

    //     const finalTotal = total - (total * discount) / 100;

    //     const balance = finalTotal - paid;

    //     if (this.elements.finalTotal) {
    //         this.elements.finalTotal.textContent = `$${this.formatMoney(finalTotal)}`;
    //     }

    //     if (this.elements.balance) {
    //         this.elements.balance.textContent = `$${this.formatMoney(balance)}`;
    //     }
    // },

    calculate() {
        const total = Math.max(
            0,
            Number.parseFloat(this.elements.totalInput?.value) || 0,
        );

        const discount = Math.min(
            100,
            Math.max(
                0,
                Number.parseFloat(this.elements.discountInput?.value) || 0,
            ),
        );

        const paid = Math.max(
            0,
            Number.parseFloat(this.elements.paidInput?.value) || 0,
        );

        const finalTotal = total * (1 - discount / 100);
        const balance = finalTotal - paid;

        if (this.elements.finalTotal) {
            this.elements.finalTotal.textContent = `$${this.formatMoney(finalTotal)}`;
        }

        if (this.elements.balance) {
            this.elements.balance.textContent = `$${this.formatMoney(balance)}`;
        }
    },

    // =========================================================
    // FINAL SUBMIT
    // =========================================================

    async submit() {
        if (this.isSaving) {
            return;
        }
        const button = this.elements.finalSubmit;

        if (!this.validateCurrentStep()) {
            return;
        }

        if (!this.selectedClasses.length) {
            alert("Please add at least one class.");
            return;
        }

        if (button) {
            button.disabled = true;
        }

        try {
            /*
             * Step 3 is saved through the Laravel API.
             */
            const data = await this.autoSave();

            if (!data?.success) {
                throw new Error(
                    data?.message ||
                        data?.error ||
                        "Student registration failed.",
                );
            }

            this.showMessage(
                data.message || "Employee registered successfully!",
                "success",
            );

            const invoiceId = data.invoice_id || this.lastInvoiceId;

            if (!invoiceId) {
                throw new Error("Invoice ID was not returned by the server.");
            }

            this.lastInvoiceId = invoiceId;

            /*
             * Open invoice in a new tab.
             */
            const invoiceUrl = `/api/v1/invoices/${encodeURIComponent(invoiceId)}/pdf`;

            const link = document.createElement("a");

            link.href = invoiceUrl;
            link.download = `invoice-${invoiceId}.pdf`;

            document.body.appendChild(link);
            link.click();
            link.remove();

            /*
             * Registration completed.
             */
            window.location.href = "/admin/registrations/students";
        } catch (error) {
            console.error("Student registration failed:", error);

            this.showError(error.message || "Student registration failed.");
        } finally {
            if (button) {
                button.disabled = false;
            }
        }
    },

    // =========================================================
    // PROFILE IMAGE PREVIEW
    // =========================================================
    profileObjectUrl: null,

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

    // =========================================================
    // HELPERS
    // =========================================================

    formatMoney(value) {
        const number = Number(value || 0);

        return number.toFixed(2);
    },

    escapeHtml(value) {
        const div = document.createElement("div");

        div.textContent = value ?? "";

        return div.innerHTML;
    },

    // showError(message) {
    //     console.error(message);

    //     /*
    //      * Replace this with your existing toast/alert component
    //      * later if you have one.
    //      */
    //     alert(message);
    // },
    showError(message) {
        this.showMessage(message, "danger");
    },
};

// =============================================================
// START
// =============================================================

document.addEventListener("DOMContentLoaded", () => {
    StudentRegistration.init();
});

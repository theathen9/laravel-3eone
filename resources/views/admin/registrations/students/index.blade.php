{{-- resources/views/admin/student/registrations.blade.php --}}

@extends('layouts.admin')

@section('title', 'Student Registrations | 3EONE')

@section('content')

<form
    id="studentForm"
    method="POST"
    enctype="multipart/form-data">
    @csrf

    <input
        type="hidden"
        name="step"
        id="stepInput"
        value="{{ old('step', 1) }}">

    <input
        type="hidden"
        name="action"
        value="register_student">
    <input
        type="hidden"
        name="student_id"
        value="{{$student_id}}">

    <input
        type="hidden"
        name="created_by"
        value="{{ session('reference_id', '') }}">

    <div class="card shadow border-0">
        <div class="card-body p-4 p-md-5">

            {{-- =========================================================
                STEP NAVIGATION
            ========================================================== --}}

            <div class="mb-4">

                <div class="progress" style="height: 8px;">
                    <div
                        id="stepProgressBar"
                        class="progress-bar bg-primary"
                        role="progressbar"
                        style="width: 0%"></div>
                </div>

                <div class="d-flex justify-content-between mt-2 small">
                    <span>Student Info</span>
                    <span>Class</span>
                    <span>Payment</span>
                </div>

            </div>


            {{-- =========================================================
                STEP 1
            ========================================================== --}}

            <div class="step" id="step1">

                <h3 class="mb-4">
                    Student Information
                </h3>

                <div class="d-flex justify-content-between">

                    <div class="w-75">

                        <div class="row g-3 mb-3">

                            <div class="col-md-4">
                                <input
                                    type="text"
                                    name="student_code"
                                    value="{{  $idCode  }}"
                                    class="form-control"
                                    placeholder="Student Code"
                                    readonly>
                            </div>

                            <div class="col-md-4">
                                <input
                                    type="text"
                                    id="register_at"
                                    name="register_at"
                                    value="{{$register_at}}"
                                    class="form-control"
                                    placeholder="Register Date">
                            </div>

                        </div>


                        {{-- Khmer Name --}}

                        <div class="row g-3 mb-3">

                            <div class="col-md-4">
                                <input
                                    type="text"
                                    name="first_name_kh"
                                    value="{{ $autoNameF  }}"
                                    class="form-control"
                                    placeholder="First Name Khmer"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <input
                                    type="text"
                                    name="middle_name_kh"
                                    value="{{ old('middle_name_kh') }}"
                                    class="form-control"
                                    placeholder="Middle Name Khmer">
                            </div>

                            <div class="col-md-4">
                                <input
                                    type="text"
                                    name="last_name_kh"
                                    value="{{ old('last_name_kh', $autoNameF ?? '') }}"
                                    class="form-control"
                                    placeholder="Last Name Khmer"
                                    required>
                            </div>

                        </div>


                        {{-- English Name --}}

                        <div class="row g-3 mb-3">

                            <div class="col-md-4">
                                <input
                                    type="text"
                                    name="first_name_en"
                                    value="{{ old('first_name_en', $autoNameEnF ?? '') }}"
                                    class="form-control"
                                    placeholder="First Name English"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <input
                                    type="text"
                                    name="middle_name_en"
                                    value="{{ old('middle_name_en') }}"
                                    class="form-control"
                                    placeholder="Middle Name English">
                            </div>

                            <div class="col-md-4">
                                <input
                                    type="text"
                                    name="last_name_en"
                                    value="{{ old('last_name_en', $autoNameEnL ?? '') }}"
                                    class="form-control"
                                    placeholder="Last Name English"
                                    required>
                            </div>

                        </div>

                    </div>

                    {{-- PHOTO --}}
                    <div class="w-25 text-center">

                        <label for="profile_image" style="cursor:pointer;">
                            <img id="preview_profile_image"
                                src="{{ asset('/images/default-user.png') }}"
                                style="
                                height:99px;
                                width:99px;
                                object-fit:cover;
                                border-radius:6px;
                                border:1px solid #ccc;
                             ">
                        </label>

                        <input type="file"
                            name="profile_image"
                            id="profile_image"
                            accept="image/*"
                            class="d-none">

                        <div class="small text-muted mt-1">
                            Click photo to upload
                        </div>

                    </div>

                </div>


                {{-- DOB / Gender / Academic Year --}}

                <div class="row g-3 mb-5">

                    <div class="col-lg-3">
                        <input
                            type="text"
                            id="dob"
                            name="dob"
                            value="{{$dob}}"
                            class="form-control"
                            placeholder="Date Of Birth"
                            required>
                    </div>

                    <div class="col-lg-3">
                        <select
                            name="gender"
                            id="gender"
                            class="form-control"
                            required>
                            <option value="">-- Gender --</option>

                            <option
                                value="Male">
                                ប្រុស
                            </option>

                            <option
                                value="Female">
                                ស្រី
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-3">
                        <input
                            type="text"
                            name="academic_year"
                            value="{{ $academic_year }}"
                            class="form-control"
                            placeholder="Academic Year"
                            required>
                    </div>

                </div>


                {{-- =====================================================
                    BIRTH ADDRESS
                ====================================================== --}}

                <h3 class="mb-4">
                    Address Date Of Birth
                </h3>

                <div class="row g-3 mb-3">

                    <div class="col-md-6">
                        <select
                            id="birth_addr_province"
                            name="birth_addr_province"
                            class="form-select"
                            required>
                            <option value="">
                                -- Province --
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">

                        <select
                            id="birth_addr_district"
                            name="birth_addr_district"
                            class="form-select"
                            disabled
                            required>
                            <option value="">
                                -- District --
                            </option>

                            <option value="other">
                                -- Other --
                            </option>
                        </select>

                        <input
                            type="text"
                            id="other_birth_addr_district"
                            class="form-control"
                            placeholder="Enter district name"
                            style="display: none;">

                    </div>

                </div>


                <div class="row g-3 mb-4">

                    <div class="col-md-6">

                        <select
                            id="birth_addr_commune"
                            name="birth_addr_commune"
                            class="form-select"
                            disabled
                            required>
                            <option value="">
                                -- Commune --
                            </option>

                            <option value="other">
                                -- Other --
                            </option>
                        </select>

                        <input
                            type="text"
                            id="other_birth_addr_commune"
                            class="form-control"
                            placeholder="Enter commune name"
                            style="display: none;">

                    </div>

                    <div class="col-md-6">

                        <select
                            id="birth_addr_village"
                            name="birth_addr_village"
                            class="form-select"
                            disabled
                            required>
                            <option value="">
                                -- Village --
                            </option>

                            <option value="other">
                                -- Other --
                            </option>
                        </select>

                        <input
                            type="text"
                            id="other_birth_addr_village"
                            class="form-control"
                            placeholder="Enter village name"
                            style="display: none;">

                    </div>

                </div>


                {{-- =====================================================
                    CURRENT ADDRESS
                ====================================================== --}}

                <h3 class="mb-4">
                    Current Address
                </h3>

                <div class="row g-3 mb-3">

                    <div class="col-md-6">

                        <select
                            id="curr_addr_province"
                            name="curr_addr_province"
                            class="form-select"
                            required>
                            <option value="">
                                -- Province --
                            </option>
                        </select>

                    </div>

                    <div class="col-md-6">

                        <select
                            id="curr_addr_district"
                            name="curr_addr_district"
                            class="form-select"
                            disabled
                            required>
                            <option value="">
                                -- District --
                            </option>

                            <option value="other">
                                -- Other --
                            </option>
                        </select>

                        <input
                            type="text"
                            id="other_curr_addr_district"
                            class="form-control"
                            placeholder="Enter district name"
                            style="display: none;">

                    </div>

                </div>


                <div class="row g-3 mb-4">

                    <div class="col-md-6">

                        <select
                            id="curr_addr_commune"
                            name="curr_addr_commune"
                            class="form-select"
                            disabled
                            required>
                            <option value="">
                                -- Commune --
                            </option>

                            <option value="other">
                                -- Other --
                            </option>
                        </select>

                        <input
                            type="text"
                            id="other_curr_addr_commune"
                            class="form-control"
                            placeholder="Enter commune name"
                            style="display: none;">

                    </div>

                    <div class="col-md-6">

                        <select
                            id="curr_addr_village"
                            name="curr_addr_village"
                            class="form-select"
                            disabled
                            required>
                            <option value="">
                                -- Village --
                            </option>

                            <option value="other">
                                -- Other --
                            </option>
                        </select>

                        <input
                            type="text"
                            id="other_curr_addr_village"
                            class="form-control"
                            placeholder="Enter village name"
                            style="display: none;">

                    </div>

                </div>


                {{-- =====================================================
                    CONTACT
                ====================================================== --}}

                <h3 class="mb-4">
                    Contact Information
                </h3>

                <div class="row g-3 mb-3">

                    <div class="col-md-6">

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $email) }}"
                            class="form-control"
                            placeholder="Email Address">

                    </div>

                </div>


                <div class="row g-3 mb-3">

                    <div class="col-md-6">

                        <input
                            type="tel"
                            name="phone1"
                            value="{{ old('phone1', $number1) }}"
                            class="form-control"
                            placeholder="Phone 1">

                    </div>

                    <div class="col-md-6">

                        <input
                            type="tel"
                            name="phone2"
                            value="{{ old('phone2') }}"
                            class="form-control"
                            placeholder="Phone 2">

                    </div>

                </div>


                {{-- =====================================================
                    GUARDIAN INFORMATION
                ====================================================== --}}

                <h3 class="mb-4">
                    Parent/Guardian Information
                </h3>

                <div class="row g-3 mb-3">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="guardian1_name_first"
                            value="{{  $autoNameGMF  }}"
                            class="form-control"
                            placeholder="Guardian First Name"
                            required>

                    </div>

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="guardian1_name_last"
                            value="{{ old('guardian1_name_last', $autoNameGML ?? '') }}"
                            class="form-control"
                            placeholder="Guardian Last Name">

                    </div>

                    <div class="col-md-4">

                        <select
                            name="guardian1_relationship"
                            class="form-select"
                            required>
                            <option value="">
                                -- Relationship --
                            </option>

                            <option value="ឪពុក">ឪពុក</option>


                            <option value="ម្តាយ">ម្តាយ</option>

                        </select>

                    </div>

                </div>


                <div class="row g-3 mb-3">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="guardian2_name_first"
                            value="{{ $autoNameGFF  }}"
                            class="form-control"
                            placeholder="Guardian First Name"
                            required>

                    </div>

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="guardian2_name_last"
                            value="{{ $autoNameGFL  }}"
                            class="form-control"
                            placeholder="Guardian Last Name"
                            required>

                    </div>

                    <div class="col-md-4">

                        <select
                            name="guardian2_relationship"
                            required
                            class="form-select">
                            <option value="">
                                -- Relationship --
                            </option>

                            <option value="ឪពុក">ឪពុក</option>


                            <option value="ម្តាយ">ម្តាយ</option>

                        </select>

                    </div>

                </div>


                {{-- Guardian Contact --}}

                <div class="row g-3 mb-3">

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="guardian1_phone"
                            value="{{  $numberG1  }}"
                            class="form-control"
                            placeholder="Guardian 1 Phone Number"
                            required>

                    </div>

                    <div class="col-md-4">

                        <input
                            type="text"
                            name="guardian2_phone"
                            class="form-control"
                            placeholder="Guardian 2 Phone Number">

                    </div>

                    <div class="col-md-4">

                        <input
                            type="email"
                            name="guardian_email"
                            class="form-control"
                            placeholder="Guardian Email">

                    </div>

                </div>


                {{-- =====================================================
                    GUARDIAN CURRENT ADDRESS
                ====================================================== --}}

                <h3 class="mb-4">
                    Parent/Guardian Current Address
                </h3>

                <div class="row g-3 mb-3">

                    <div class="col-md-6">

                        <select
                            id="guardian_curr_addr_province"
                            name="guardian_curr_addr_province"
                            class="form-select"
                            required>
                            <option value="">
                                -- Province --
                            </option>
                        </select>

                    </div>

                    <div class="col-md-6">

                        <select
                            id="guardian_curr_addr_district"
                            name="guardian_curr_addr_district"
                            class="form-select"
                            disabled
                            required>
                            <option value="">
                                -- District --
                            </option>

                            <option value="other">
                                -- Other --
                            </option>
                        </select>

                        <input
                            type="text"
                            id="other_guardian_curr_addr_district"
                            class="form-control"
                            placeholder="Enter district name"
                            style="display: none;">

                    </div>

                </div>


                <div class="row g-3 mb-4">

                    <div class="col-md-6">

                        <select
                            id="guardian_curr_addr_commune"
                            name="guardian_curr_addr_commune"
                            class="form-select"
                            disabled
                            required>
                            <option value="">
                                -- Commune --
                            </option>

                            <option value="other">
                                -- Other --
                            </option>
                        </select>

                        <input
                            type="text"
                            id="other_guardian_curr_addr_commune"
                            class="form-control"
                            placeholder="Enter commune name"
                            style="display: none;">

                    </div>

                    <div class="col-md-6">

                        <select
                            id="guardian_curr_addr_village"
                            name="guardian_curr_addr_village"
                            class="form-select"
                            disabled
                            required>
                            <option value="">
                                -- Village --
                            </option>

                            <option value="other">
                                -- Other --
                            </option>
                        </select>

                        <input
                            type="text"
                            id="other_guardian_curr_addr_village"
                            class="form-control"
                            placeholder="Enter village name"
                            style="display: none;">

                    </div>

                </div>


                <button
                    type="button"
                    class="btn btn-primary next-step">
                    Next
                </button>

            </div>


            {{-- =========================================================
                STEP 2 — CLASS
            ========================================================== --}}

            <!-- ================= STEP 2 ================= -->
            <div class="step d-none" id="step2">

                <h3 class="mb-4">Assign Class</h3>

                <div class="row">

                    <!-- EXISTING CLASSES -->
                    <div class="col-lg-6 mb-3">

                        <label for="classSelect" class="form-label">
                            Select Class
                        </label>

                        <select id="classSelect" class="form-select">
                            <option value=""> -- Choose Class -- </option>
                            @foreach ($classes as $class)
                            <option value="{{ $class->class_id }}" data-code="{{ $class->class_code }}" data-name="{{ $class->class_name }}" data-course="{{ $class->course?->course_name ?? '' }}" data-teacher="{{ $class->teacher?->employee_name ?? '' }}" data-room="{{ $class->room?->room_name ?? '' }}" data-slot="{{ $class->timeSlot?->slot_name ?? '' }}" data-start="{{ $class->timeSlot?->start_time ?? '' }}" data-end="{{ $class->timeSlot?->end_time ?? '' }}">
                                {{ $class->class_code }} - {{ $class->class_name }}
                            </option>
                            @endforeach
                        </select>

                        <button
                            type="button"
                            id="addClassBtn"
                            class="btn btn-success w-100 mt-3">
                            + Add Class
                        </button>

                    </div>


                    <!-- CREATE NEW CLASS -->
                    <div class="col-lg-6 mb-3">

                        <div class="card class-card p-3 h-100 border-primary">

                            <strong class="text-primary">
                                + Create New Class
                            </strong>

                            <div class="small text-muted mt-2">
                                Add a new class with schedule and details
                            </div>

                            <div id="newClassForm" class="mt-3 d-none">

                                <input
                                    type="text"
                                    name="new_class_name"
                                    class="form-control mb-2"
                                    placeholder="Class name">

                                <select
                                    name="new_day"
                                    class="form-select mb-2">
                                    <option value="">-- Select Day --</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>

                                <input
                                    type="time"
                                    name="new_start"
                                    class="form-control mb-2">

                                <input
                                    type="time"
                                    name="new_end"
                                    class="form-control mb-2">

                            </div>

                            <button
                                type="button"
                                id="btnNewClass"
                                class="btn btn-primary mt-2">
                                Create New Class
                            </button>

                        </div>

                    </div>

                </div>


                <!-- SELECTED CLASSES -->
                <div class="mt-4">

                    <table
                        class="table table-bordered"
                        id="classTable">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Course Name</th>
                                <th>Teacher</th>
                                <th>Subject</th>
                                <th>Room</th>
                                <th>Study</th>
                                <th>Time</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>

                </div>


                <!-- NAVIGATION -->
                <button
                    type="button"
                    class="btn btn-secondary prev-step">
                    Back
                </button>

                <button
                    type="button"
                    class="btn btn-primary next-step">
                    Next
                </button>

            </div>


            {{-- =========================================================
                STEP 3 — PAYMENT
            ========================================================== --}}

            <div
                class="step d-none"
                id="step3">

                <h3 class="mb-4">
                    Payment Summary
                </h3>


                {{-- Class Summary --}}

                <div
                    id="classSummary"
                    class="mb-4"></div>


                {{-- Payment --}}

                <div class="row g-3">

                    <div class="col-md-4">

                        <label>
                            Total Fee
                        </label>

                        <input
                            type="number"
                            id="totalInput"
                            class="form-control"
                            readonly>

                    </div>


                    <div class="col-md-4">

                        <label>
                            Payment
                        </label>

                        <select
                            class="form-control"
                            name="payment_method_id"
                            required>

                            @foreach ($paymentsMethods ?? [] as $paymentsMethod)

                            <option value="{{ $paymentsMethod['method_id'] }}">
                                {{ $paymentsMethod['method_name'] }}
                            </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-4">

                        <label>
                            Discount %
                        </label>

                        <input
                            type="number"
                            id="discount"
                            name="discount"
                            class="form-control"
                            value="{{ old('discount', 0) }}"
                            min="0"
                            max="100">

                    </div>


                    <div class="col-md-4">

                        <label>
                            Amount Paid
                        </label>

                        <input
                            type="number"
                            id="paid"
                            name="amount_paid"
                            class="form-control"
                            value="{{ old('amount_paid') }}"
                            min="0"
                            required>

                    </div>

                </div>


                {{-- Result --}}

                <div class="mt-4">

                    <strong>
                        Final Total:
                    </strong>

                    <span id="finalTotal">
                        0
                    </span>

                    <br>

                    <strong>
                        Balance:
                    </strong>

                    <span id="balance">
                        0
                    </span>

                </div>


                {{-- Buttons --}}

                <div class="mt-4">

                    <button
                        type="button"
                        class="btn btn-secondary prev-step">
                        Back
                    </button>

                    <button
                        id="finalSubmit"
                        type="button"
                        class="btn btn-success">
                        Register
                    </button>

                </div>

            </div>

        </div>
    </div>

</form>

@endsection

@push('scripts')
@vite([
'resources/js/student-registration.js',
])


<!-- <script>
    // let btn = document.getElementById("finalSubmit");

    const Wizard = {
        currentStep: 0,
        steps: [],
        isSaving: false,
        csrf: null,
        progressBar: null,

        init(config) {
            this.steps = Array.from(document.querySelectorAll(config.stepsSelector));
            csrfSelector: '[name="csrf_token"]' = document.querySelector(config.csrfSelector)?.value || null;
            this.progressBar = document.getElementById("stepProgressBar");

            this.bindEvents();
            this.showStep(0);
        },

        bindEvents() {
            document.addEventListener("click", async (e) => {
                const next = e.target.closest(".next-step");
                const prev = e.target.closest(".prev-step");

                if (next) await this.next();
                if (prev) this.prev();
            });
        },

        getStep() {
            return this.steps[this.currentStep];
        },

        validate() {
            const inputs = this.getStep().querySelectorAll("[required]");
            let ok = true;

            inputs.forEach(i => {

                if (i.disabled) return; // ✅ SKIP disabled inputs

                if (!i.value || !i.value.trim()) {
                    i.classList.add("is-invalid");
                    ok = false;
                } else {
                    i.classList.remove("is-invalid");
                }
            });

            return ok;
        },

        async next() {
            if (!this.validate()) return;

            await this.autoSave();

            if (this.currentStep < this.steps.length - 1) {
                this.currentStep++;
                this.showStep(this.currentStep);
            }
        },

        prev() {
            if (this.currentStep > 0) {
                this.currentStep--;
                this.showStep(this.currentStep);
            }
        },

        showStep(i) {
            this.steps.forEach((s, idx) => {
                s.classList.toggle("d-none", idx !== i);
            });

            this.updateProgress();
            document.getElementById("stepInput").value = i + 1;
        },

        updateProgress() {
            if (!this.progressBar) return;

            const percent = ((this.currentStep + 1) / this.steps.length) * 100;
            this.progressBar.style.width = percent + "%";
        },

        async autoSave() {
            if (this.isSaving) return;
            this.isSaving = true;

            if (typeof updateHiddenInputs === "function") {
                updateHiddenInputs();
            }

            const form = document.getElementById("studentForm");
            const formData = new FormData(form);

            formData.append("step", this.currentStep + 1);
            formData.append("csrf_token", this.csrf);

            try {
                const res = await fetch("/api/v1/register_process.php", {
                    method: "POST",
                    body: formData,
                    credentials: "same-origin"
                });

                const text = await res.text();
                console.log("RAW RESPONSE:", text);

                const data = JSON.parse(text);

                if (!data.success) {
                    throw new Error(data.error || "Save failed");
                }

                console.log("Saved step:", this.currentStep);

                return data; // ✅ IMPORTANT

            } catch (err) {
                console.error("AutoSave error:", err);
                throw err; // ✅ propagate error
            } finally {
                this.isSaving = false;
            }
        }
    };


    document.addEventListener("DOMContentLoaded", async function() {

        let lastInvoiceId = null;

        const btnSumitStudent = document.getElementById("finalSubmit");
        // const btnPrint = document.getElementById("printSubmit");


        const classSelect = document.getElementById("classSelect");
        const addBtn = document.getElementById("addClassBtn");
        const tableBody = document.querySelector("#classTable tbody");

        const totalInput = document.getElementById("totalInput");
        const discountInput = document.getElementById("discount");
        const paidInput = document.getElementById("paid");

        const finalTotalEl = document.getElementById("finalTotal");
        const balanceEl = document.getElementById("balance");
        const classSummary = document.getElementById("classSummary");

        let selectedClasses = []; // ✅ SINGLE SOURCE OF TRUTH

        // ➕ Add Class
        addBtn.addEventListener("click", function() {

            const option = classSelect.selectedOptions[0];

            if (!option.value) {
                alert("Please select a class");
                return;
            }

            if (selectedClasses.some(c => c.id === option.value)) {
                alert("Class already added");
                return;
            }

            const classData = {
                id: option.value,
                code: option.dataset.code,
                name: option.dataset.name,
                course: option.dataset.course,
                teacher: option.dataset.teacher,
                room: option.dataset.room,
                study: option.dataset.study,
                time: option.dataset.time,
                price: parseFloat(option.dataset.price || 0)
            };

            selectedClasses.push(classData);

            renderTable();
            updateSummary();
        });

        // 🗑 Remove class
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-class")) {

                const id = e.target.dataset.id;

                selectedClasses = selectedClasses.filter(c => c.id !== id);

                renderTable();
                updateSummary();
            }
        });

        function updateHiddenInputs() {

            // remove old inputs
            document.querySelectorAll(".class-hidden-input").forEach(el => el.remove());

            const form = document.getElementById("studentForm") || document.body;

            selectedClasses.forEach(c => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "class_ids[]";
                input.value = c.id;
                input.classList.add("class-hidden-input");

                form.appendChild(input);
            });
        }
        // 📋 Render table (STEP 2)
        function renderTable() {
            tableBody.innerHTML = "";

            selectedClasses.forEach(c => {
                const row = document.createElement("tr");

                row.innerHTML = `
                <td>${c.code}</td>
                <td>${c.name}</td>
                <td>${c.course}</td>
                <td>${c.teacher}</td>
                <td>${c.room}</td>
                <td>${c.study}</td>
                <td>${c.time}</td>
                <td>$${c.price}</td>
                <td>
                    <button type="button"
                        class="btn btn-danger btn-sm remove-class"
                        data-id="${c.id}">
                        Remove
                    </button>
                </td>
            `;

                tableBody.appendChild(row);
            });

            // 🔥 rebuild hidden inputs properly (IMPORTANT FIX)
            updateHiddenInputs();
        }

        // 📊 Payment Summary (STEP 3)
        function updateSummary() {

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

            selectedClasses.forEach(c => {
                total += c.price;

                html += `
                    <tr>
                        <td>${c.code}</td>
                        <td>${c.name}</td>
                        <td>${c.course}</td>
                        <td>${c.teacher}</td>
                        <td>${c.room}</td>
                        <td>${c.study}</td>
                        <td>${c.time}</td>
                        <td>$${c.price}</td>
                    </tr>
                `;
            });

            html += "</tbody></table>";

            classSummary.innerHTML = html;

            totalInput.value = total;

            calculate();


            // ensure hidden inputs always updated
            updateHiddenInputs();
        }

        // 🧮 Calculation
        function calculate() {

            const total = parseFloat(totalInput.value || 0);
            const discount = parseFloat(discountInput.value || 0);
            const paid = parseFloat(paidInput.value || 0);

            const finalTotal = total - (total * discount / 100);
            const balance = finalTotal - paid;

            finalTotalEl.innerText = `$${finalTotal}`;
            balanceEl.innerText = `$${balance}`;
        }

        // 🔄 Live calculation
        discountInput.addEventListener("input", calculate);
        paidInput.addEventListener("input", calculate);

        Wizard.init({
            stepsSelector: ".step",
            csrfSelector: '[name="csrf_token"]'
        });



        btnSumitStudent.addEventListener("click", async () => {

            btnSumitStudent.disabled = true;
            try {
                const data = await Wizard.autoSave();

                console.log("STEP 3 RESPONSE:", data);

                // SESSION EXPIRED
                if (!data.success && data.error === "Session expired") {
                    window.location.href = "${BASE_URL}/admin/register.php?error=session_expired";
                    return;
                }

                // OTHER ERRORS
                if (!data.success) {
                    alert(data.error || "Something went wrong");
                    btnSumitStudent.disabled = false;
                    return;
                }

                if (data.invoice_id) {
                    lastInvoiceId = data.invoice_id;
                }

                const invoiceId = lastInvoiceId;

                if (!invoiceId) {
                    alert("Invoice ID not found");
                    btnSumitStudent.disabled = false;
                    return;
                }

                // Open invoice FIRST
                const invoiceWindow = window.open(
                    `${BASE_URL}/api/v1/generate_invoice.php?id=${invoiceId}`,
                    "_blank"
                );

                if (!invoiceWindow) {
                    alert("Popup blocked. Please allow popups.");
                    btnSumitStudent.disabled = false;
                    return;
                }

                // redirect AFTER opening
                setTimeout(() => {
                    window.location.href = "${BASE_URL}/admin/register.php";
                }, 1000);

            } catch (err) {
                console.error(err);
                btnSumitStudent.disabled = false;
                window.location.href = "${BASE_URL}/admin/register.php";
            }
        });



    })
</script> -->

@endpush
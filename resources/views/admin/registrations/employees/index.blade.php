{{-- resources/views/admin/employees.registrations.blade.php --}}
<?php

// $idCodeStaff;
// $autoNameFS = "សា_" . $idCodeStaff;
// $autoNameMS = "មា_" . $idCodeStaff;
// $autoNameLS = "នា_" . $idCodeStaff;

// $autoNameEnFS = "kim_" . $idCodeStaff;
// $autoNameEnMS = "M_" . $idCodeStaff;
// $autoNameEnLS = "Na_" . $idCodeStaff;

// $student_code = sprintf("STU-%s-%02d", date("Y"), $idCodeStaff);

$start = strtotime("-25 years");
$end = strtotime("-10 years");

$randomTimestamp = rand($start, $end);
$dob = date("Y-m-d", $randomTimestamp);

$prefixes = [
    '010',
    '011',
    '012',
    '015',
    '016',
    '017',
    '018',
    '060',
    '061',
    '066',
    '067',
    '068',
    '069',
    '070',
    '077',
    '078',
    '085',
    '086',
    '087',
    '088',
    '089',
    '090',
    '092',
    '093',
    '095',
    '096',
    '097',
    '098',
    '099'
];

$prefix = $prefixes[array_rand($prefixes)];

$number1 = $prefix . rand(1000000, 9999999);
$number2 = $prefix . rand(1000000, 9999999);

$email = "user" . rand(1000, 9999) . "@gmail.com";
?>


@extends('layouts.admin')

@section('title', 'employees Registrations | 3EONE')

@section('content')

<div class="card shadow border-0">
    <div class="card-body p-4 p-md-5">

        {{-- IMPORTANT: add a form --}}
        <form method="POST"
            enctype="multipart/form-data"
            id="employeeRegistration"
            novalidate>

            @csrf

            <input type="hidden" name="employee_id" value="{{ $idCodeStaff }}">
            <input type="hidden" name="position_id" value="1">

            {{-- ================= STAFF INFORMATION ================= --}}
            <h3 class="mb-4">Staff Information</h3>


            <!-- Registration message -->
            <div id="registrationMessage"
                class="alert d-none"
                role="alert"
                aria-live="polite">
            </div>

            <div class="d-flex justify-content-between">

                <div class="w-75">

                    <div class="row g-3 mb-3">

                        <div class="col-md-4">
                            <input type="text"
                                value="{{ $autoNameFS }}"
                                name="first_name_kh"
                                class="form-control"
                                placeholder="First Name Khmer"
                                required>
                        </div>

                        <div class="col-md-4">
                            <input type="text"
                                value=""
                                name="middle_name_kh"
                                class="form-control"
                                placeholder="Middle Name Khmer">
                        </div>

                        <div class="col-md-4">
                            <input type="text"
                                value="{{ $autoNameLS }}"
                                name="last_name_kh"
                                class="form-control"
                                placeholder="Last Name Khmer"
                                required>
                        </div>

                    </div>

                    <div class="row g-3 mb-3">

                        <div class="col-md-4">
                            <input type="text"
                                value="{{ $autoNameEnFS }}"
                                name="first_name_en"
                                class="form-control"
                                placeholder="First Name English"
                                required>
                        </div>

                        <div class="col-md-4">
                            <input type="text"
                                value=""
                                name="middle_name_en"
                                class="form-control"
                                placeholder="Middle Name English">
                        </div>

                        <div class="col-md-4">
                            <input type="text"
                                value="{{ $autoNameEnLS }}"
                                name="last_name_en"
                                class="form-control"
                                placeholder="Last Name English"
                                required>
                        </div>

                    </div>

                </div>

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

            {{-- ================= BASIC INFORMATION ================= --}}
            <div class="row g-3 mb-5">

                <div class="col-lg-3">
                    <input type="date"
                        id="dob"
                        name="dob"
                        value="{{ $dob }}"
                        class="form-control"
                        required>
                </div>

                <div class="col-lg-3">
                    <select name="gender"
                        id="gender"
                        class="form-select"
                        required>

                        <option value="">-- Gender --</option>
                        <option value="Male">ប្រុស</option>
                        <option value="Female">ស្រី</option>

                    </select>
                </div>

                <div class="col-lg-3">
                    <select name="position"
                        id="position"
                        class="form-select"
                        required>

                        <option value="">-- position --</option>
                        @foreach ($positions ?? [] as $position)

                        <option value="{{ $position['position_id'] }}">
                            {{ $position['position_name'] }}
                        </option>

                        @endforeach

                    </select>


                </div>

                <div class="col-lg-3">
                    <input type="date"
                        id="hired_at"
                        name="hired_at"
                        class="form-control"
                        required>
                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- BIRTH ADDRESS --}}
            {{-- ========================================================= --}}

            <h3 class="mb-4">Address Date Of Birth</h3>

            <div class="row g-3 mb-3">

                <div class="col-md-6">

                    <select id="birth_addr_province"
                        name="birth_addr_province"
                        class="form-select"
                        required>

                        <option value="">-- Province --</option>

                    </select>

                </div>

                <div class="col-md-6">

                    <select id="birth_addr_district"
                        name="birth_addr_district"
                        class="form-select"
                        disabled
                        required>

                        <option value="">-- District --</option>
                        <option value="other">-- Other --</option>

                    </select>

                    <input type="text"
                        id="other_birth_addr_district"
                        name="other_birth_addr_district"
                        class="form-control"
                        placeholder="Enter district name"
                        style="display:none;">

                </div>

            </div>

            <div class="row g-3 mb-4">

                <div class="col-md-6">

                    <select id="birth_addr_commune"
                        name="birth_addr_commune"
                        class="form-select"
                        disabled
                        required>

                        <option value="">-- Commune --</option>
                        <option value="other">-- Other --</option>

                    </select>

                    <input type="text"
                        id="other_birth_addr_commune"
                        name="other_birth_addr_commune"
                        class="form-control"
                        placeholder="Enter commune name"
                        style="display:none;">

                </div>

                <div class="col-md-6">

                    <select id="birth_addr_village"
                        name="birth_addr_village"
                        class="form-select"
                        disabled
                        required>

                        <option value="">-- Village --</option>
                        <option value="other">-- Other --</option>

                    </select>

                    <input type="text"
                        id="other_birth_addr_village"
                        name="other_birth_addr_village"
                        class="form-control"
                        placeholder="Enter village name"
                        style="display:none;">

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- CURRENT ADDRESS --}}
            {{-- ========================================================= --}}

            <h3 class="mb-4">Current Address</h3>

            <div class="row g-3 mb-3">

                <div class="col-md-6">

                    <select id="curr_addr_province"
                        name="curr_addr_province"
                        class="form-select"
                        required>

                        <option value="">-- Province --</option>

                    </select>

                </div>

                <div class="col-md-6">

                    <select id="curr_addr_district"
                        name="curr_addr_district"
                        class="form-select"
                        disabled
                        required>

                        <option value="">-- District --</option>
                        <option value="other">-- Other --</option>

                    </select>

                    <input type="text"
                        id="other_curr_addr_district"
                        name="other_curr_addr_district"
                        class="form-control "
                        placeholder="Enter district name"
                        style="display:none;">

                </div>

            </div>

            <div class="row g-3 mb-4">

                <div class="col-md-6">

                    <select id="curr_addr_commune"
                        name="curr_addr_commune"
                        class="form-select"
                        disabled
                        required>

                        <option value="">-- Commune --</option>
                        <option value="other">-- Other --</option>

                    </select>

                    <input type="text"
                        id="other_curr_addr_commune"
                        name="other_curr_addr_commune"
                        class="form-control"
                        placeholder="Enter commune name"
                        style="display:none;">

                </div>

                <div class="col-md-6">

                    <select id="curr_addr_village"
                        name="curr_addr_village"
                        class="form-select"
                        disabled
                        required>

                        <option value="">-- Village --</option>
                        <option value="other">-- Other --</option>

                    </select>

                    <input type="text"
                        id="other_curr_addr_village"
                        name="other_curr_addr_village"
                        class="form-control"
                        placeholder="Enter village name"
                        style="display:none;">

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- CONTACT INFORMATION --}}
            {{-- ========================================================= --}}

            <h3 class="mb-4">Contact Information</h3>

            <div class="row g-3 mb-4">

                <div class="col-md-6">
                    <input type="email"
                        value="{{ $email }}"
                        name="email"
                        class="form-control"
                        placeholder="Email Address">
                </div>

                <div class="col-md-6">
                    <input type="tel"
                        value="{{ $number1 }}"
                        name="phone1"
                        class="form-control"
                        placeholder="Phone Number 1">
                </div>

                <div class="col-md-6">
                    <input type="tel"
                        value="{{ $number2 }}"
                        name="phone2"
                        class="form-control"
                        placeholder="Phone Number 2">
                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- PLATFORM INFORMATION --}}
            {{-- ========================================================= --}}

            <h3 class="mb-4">Platform Information</h3>

            <div class="row g-3 mb-4">

                <div class="col-md-4">
                    <input type="tel"
                        name="phone_number"
                        class="form-control"
                        placeholder="Phone Number">
                </div>

                <div class="col-md-4">
                    <input type="url"
                        name="account_url"
                        class="form-control"
                        placeholder="Account Link">
                </div>

                <div class="col-md-4">

                    <select name="platform_type"
                        class="form-select">

                        <option value="">Select Platform</option>
                        <option value="Telegram">Telegram</option>

                    </select>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- SUBMIT --}}
            {{-- ========================================================= --}}

            <div class="w-100 d-flex justify-content-center mt-5">

                <button id="finalSubmit"
                    type="submit"
                    class="btn btn-primary"
                    style="width:117px;">

                    Register

                </button>

            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')

@vite([
'resources/js/employee-registration.js',
])
@endpush
@extends('layouts.admin')

@section('title', 'Student Details | 3EONE')

@section('content')
@php
    $fullName = trim(($student->first_name_en ?? '') . ' ' . ($student->last_name_en ?? '')) ?: 'Unnamed Student';
    $khmerName = trim(($student->first_name_kh ?? '') . ' ' . ($student->last_name_kh ?? ''));
    $studentCode = $student->student_code ?: 'STU-' . str_pad($student->student_id, 5, '0', STR_PAD_LEFT);
    $status = strtolower((string) ($student->status ?? 'draft'));
    $statusClass = match ($status) {
        '1', 'active' => 'bg-green-50 text-green-700',
        '0', 'inactive' => 'bg-gray-100 text-gray-600',
        default => 'bg-orange-50 text-orange-700',
    };
    $statusLabel = match ($status) {
        '1', 'active' => 'Active',
        '0', 'inactive' => 'Inactive',
        default => ucfirst($status),
    };
    $currentAddress = collect([
        $student->curr_addr_village,
        $student->curr_addr_commune,
        $student->curr_addr_district,
        $student->curr_addr_province,
    ])->filter(fn ($part) => filled($part))->implode(', ');
    $birthAddress = collect([
        $student->birth_addr_village,
        $student->birth_addr_commune,
        $student->birth_addr_district,
        $student->birth_addr_province,
    ])->filter(fn ($part) => filled($part))->implode(', ');
    $guardianAddress = collect([
        $student->guardian_curr_addr_village,
        $student->guardian_curr_addr_commune,
        $student->guardian_curr_addr_district,
        $student->guardian_curr_addr_province,
    ])->filter(fn ($part) => filled($part))->implode(', ');
@endphp

<div class="mx-auto w-full max-w-screen-xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('admin.people.students') }}" class="hover:text-[#b87d49]">People / Students</a>
                <span>/</span>
                <span class="font-medium text-[#b87d49]">Student Details</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Student Details</h1>
        </div>
        <a href="{{ route('admin.people.students') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
            </svg>
            Back to Students
        </a>
    </div>

    <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full border-2 border-orange-100 bg-orange-50 text-xl font-bold text-[#b87d49]">
                @if ($student->profile_image)
                    <img src="{{ asset('storage/' . $student->profile_image) }}" alt="{{ $fullName }}" class="h-full w-full object-cover">
                @else
                    {{ strtoupper(substr($fullName, 0, 1)) }}
                @endif
            </div>
            <div class="min-w-0">
                <h2 class="text-xl font-semibold text-gray-900">{{ $fullName }}</h2>
                @if ($khmerName !== '')
                    <p class="mt-1 text-sm text-gray-500">{{ $khmerName }}</p>
                @endif
                <p class="mt-1 text-sm text-gray-500">{{ $studentCode }} · Student #{{ $student->student_id }}</p>
            </div>
            <span class="inline-flex w-fit items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                {{ $statusLabel }}
            </span>
        </div>
    </section>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-base font-semibold text-gray-900">Personal Information</h2>
            <dl class="grid gap-4 sm:grid-cols-2">
                <div><dt class="text-xs font-medium uppercase text-gray-500">Gender</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->gender ?: 'Not provided' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Date of Birth</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->dob?->format('M d, Y') ?? 'Not provided' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Academic Year</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->academic_year ?: 'Not provided' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Registration Date</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->register_at?->format('M d, Y') ?? 'Not provided' }}</dd></div>
            </dl>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-base font-semibold text-gray-900">Contact Information</h2>
            <dl class="grid gap-4 sm:grid-cols-2">
                <div><dt class="text-xs font-medium uppercase text-gray-500">Email</dt><dd class="mt-1 break-words text-sm text-gray-900">{{ $student->email ?: 'Not provided' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Phone 1</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->phone1 ?: 'Not provided' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Phone 2</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->phone2 ?: 'Not provided' }}</dd></div>
            </dl>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-base font-semibold text-gray-900">Address</h2>
            <dl class="space-y-4">
                <div><dt class="text-xs font-medium uppercase text-gray-500">Current Address</dt><dd class="mt-1 text-sm text-gray-900">{{ $currentAddress ?: 'Not provided' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Birth Address</dt><dd class="mt-1 text-sm text-gray-900">{{ $birthAddress ?: 'Not provided' }}</dd></div>
            </dl>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-base font-semibold text-gray-900">Guardian Information</h2>
            <dl class="grid gap-4 sm:grid-cols-2">
                <div><dt class="text-xs font-medium uppercase text-gray-500">Guardian 1</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->guardian1_name ?: 'Not provided' }}{{ $student->guardian1_relationship ? ' · ' . $student->guardian1_relationship : '' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Guardian 1 Phone</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->guardian1_phone ?: 'Not provided' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Guardian 2</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->guardian2_name ?: 'Not provided' }}{{ $student->guardian2_relationship ? ' · ' . $student->guardian2_relationship : '' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Guardian 2 Phone</dt><dd class="mt-1 text-sm text-gray-900">{{ $student->guardian2_phone ?: 'Not provided' }}</dd></div>
                <div><dt class="text-xs font-medium uppercase text-gray-500">Guardian Email</dt><dd class="mt-1 break-words text-sm text-gray-900">{{ $student->guardian_email ?: 'Not provided' }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-xs font-medium uppercase text-gray-500">Guardian Address</dt><dd class="mt-1 text-sm text-gray-900">{{ $guardianAddress ?: 'Not provided' }}</dd></div>
            </dl>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:col-span-2 sm:p-6">
            <h2 class="mb-4 text-base font-semibold text-gray-900">Enrollments</h2>
            @forelse ($student->enrollments as $enrollment)
                <div class="flex flex-col gap-2 border-b border-gray-100 py-3 last:border-0 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm font-medium text-gray-900">{{ $enrollment->class?->class_name ?? 'Class #' . $enrollment->class_id }}</p>
                    <p class="text-sm text-gray-500">Price: {{ number_format((float) $enrollment->price, 2) }} · Discount: {{ number_format((float) $enrollment->discount, 2) }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">No class enrollments.</p>
            @endforelse
        </section>
    </div>
</div>
@endsection

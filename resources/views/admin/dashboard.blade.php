{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.admin')

@section('title', 'Dashboard | 3EONE')

@section('page-header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3 mb-1">
            Dashboard
        </h1>

        <p class="text-muted mb-0">
            Welcome to 3EONE Administration.
        </p>
    </div>
</div>
@endsection

@section('content')

<div class="row g-4">

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Students
                </div>

                <h3 class="mt-2 mb-0">
                    {{ $students ?? 0 }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Teachers
                </div>

                <h3 class="mt-2 mb-0">
                    {{ $teachers ?? 0 }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Classes
                </div>

                <h3 class="mt-2 mb-0">
                    {{ $classes ?? 0 }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted">
                    Revenue
                </div>

                <h3 class="mt-2 mb-0">
                    ${{ number_format($revenue ?? 0, 2) }}
                </h3>
            </div>
        </div>


    </div>

    @endsection
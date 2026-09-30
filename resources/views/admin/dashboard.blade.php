<!-- .resources\views\admin\dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">
    
    <h1 class="mb-4">
        Dashboard
    </h1>
    
    <div class="row">
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    Users
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    Students
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    Teachers
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    Courses
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                
                <button type="submit" class="btn btn-danger">
                    Logout
                </button>
            </form>
        </div>
        
        
    </div>
    
</div>

@endsection
@vite('resources/js/dashboard.js')
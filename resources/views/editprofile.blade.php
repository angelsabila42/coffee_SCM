@extends('layouts.app')
@section('page-title', 'Edit Profile')
@section('content')
<div class="container mt-4 d-flex justify-content-center">
    <div class="card shadow p-4" style="max-width: 800px; width: 100%;">
        <div class="card-body">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('editprofile.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- Upload Image -->
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" class="rounded-circle"
                            alt="{{ auth()->user()->name ?? 'Profile Image' }}" width="150" height="150">
                    </div>
                    <input type="file" name="profile_picture" class="form-control">
                </div>

                <!-- Account Details -->
                <h6>Account Details</h6>
                <div class="row mb-3">
                    <div class="col">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="name" value="{{ old('name', $user->name) }}">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                </div>
                <button class="btn btn-primary" type="submit">Update Profile</button>
            </form>

            <hr class="my-4">

            <form action="{{ route('editprofile.password') }}" method="post">
                @csrf
                <!-- Change Password -->
                <h6>Change Password</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="currentPassword" name="current_password">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePassword2('currentPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="newPassword" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" name="new_password">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePassword('newPassword')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmPassword"
                            name="new_password_confirmation">
                        <button class="btn btn-outline-secondary" type="button"
                            onclick="togglePassword1('confirmPassword')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning mt-3">Change Password</button>
            </form>

        </div>
    </div>
</div>

<script>
    function togglePassword(id){
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }

    const togglePassword1 = togglePassword;
    const togglePassword2 = togglePassword;
</script>
@endsection

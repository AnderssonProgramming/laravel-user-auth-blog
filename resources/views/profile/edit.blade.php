@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
        <p class="mt-2 text-gray-600">Manage your account information</p>
    </div>

    <!-- Update Profile Information -->
    <div class="card p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
        
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="label">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $user->name) }}"
                    class="input w-full @error('name') border-red-500 @enderror" 
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="{{ old('email', $user->email) }}"
                    class="input w-full @error('email') border-red-500 @enderror" 
                    required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if ($user->email_verified_at)
                    <p class="mt-1 text-sm text-green-600">
                        ✓ Email verified
                    </p>
                @endif
            </div>

            <!-- Role (Read-only) -->
            <div class="mb-4">
                <label class="label">Role</label>
                <input 
                    type="text" 
                    value="{{ ucfirst($user->role->name ?? 'User') }}"
                    class="input w-full bg-gray-100" 
                    disabled>
                <p class="mt-1 text-sm text-gray-500">Contact an administrator to change your role</p>
            </div>

            <div class="flex items-center justify-end">
                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-green-600 mr-4">Saved successfully!</p>
                @endif
                <button type="submit" class="btn-primary">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Update Password -->
    <div class="card p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Update Password</h2>
        
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="mb-4">
                <label for="current_password" class="label">Current Password</label>
                <input 
                    type="password" 
                    name="current_password" 
                    id="current_password" 
                    class="input w-full @error('current_password', 'updatePassword') border-red-500 @enderror" 
                    required>
                @error('current_password', 'updatePassword')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-4">
                <label for="password" class="label">New Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="input w-full @error('password', 'updatePassword') border-red-500 @enderror" 
                    required>
                @error('password', 'updatePassword')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="label">Confirm Password</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="input w-full" 
                    required>
            </div>

            <div class="flex items-center justify-end">
                @if (session('status') === 'password-updated')
                    <p class="text-sm text-green-600 mr-4">Password updated!</p>
                @endif
                <button type="submit" class="btn-primary">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Account -->
    <div class="card p-6 border-red-200">
        <h2 class="text-xl font-semibold mb-4 text-red-600">Delete Account</h2>
        <p class="text-gray-600 mb-4">
            Once your account is deleted, all of its resources and data will be permanently deleted. 
            Before deleting your account, please download any data or information that you wish to retain.
        </p>
        
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label for="delete_password" class="label">Confirm Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="delete_password" 
                    class="input w-full @error('password', 'userDeletion') border-red-500 @enderror" 
                    placeholder="Enter your password to confirm"
                    required>
                @error('password', 'userDeletion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-danger">
                Delete Account
            </button>
        </form>
    </div>
</div>
@endsection

<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <h2 class="text-2xl font-bold text-center mb-6">Reset Password</h2>

        <!-- Email Address -->
        <div>
            <label for="email" class="label">Email</label>
            <input id="email" class="input block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="label">New Password</label>
            <input id="password" class="input block mt-1 w-full" type="password" name="password" required />
            @error('password')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="label">Confirm Password</label>
            <input id="password_confirmation" class="input block mt-1 w-full" type="password" name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn-primary w-full justify-center">
                Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>

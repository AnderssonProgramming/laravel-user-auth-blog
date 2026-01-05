<x-guest-layout>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <h2 class="text-2xl font-bold text-center mb-2">Forgot Password?</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            No problem. Just let us know your email address and we will email you a password reset link.
        </p>

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('status') }}
            </div>
        @endif

        <!-- Email Address -->
        <div>
            <label for="email" class="label">Email</label>
            <input id="email" class="input block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn-primary w-full justify-center">
                Email Password Reset Link
            </button>
        </div>

        <div class="mt-4 text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-900 font-medium">
                Back to login
            </a>
        </div>
    </form>
</x-guest-layout>

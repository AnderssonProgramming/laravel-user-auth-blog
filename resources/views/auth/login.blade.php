<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2 class="text-2xl font-bold text-center mb-6">Sign in to your account</h2>

        <!-- Email Address -->
        <div>
            <label for="email" class="label">Email</label>
            <input id="email" class="input block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="label">Password</label>
            <input id="password" class="input block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            @error('password')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50" name="remember">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif

            <button type="submit" class="btn-primary">
                Log in
            </button>
        </div>

        <div class="mt-4 text-center text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-900 font-medium">
                Sign up
            </a>
        </div>
    </form>
</x-guest-layout>

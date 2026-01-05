<x-guest-layout>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <h2 class="text-2xl font-bold text-center mb-2">Confirm Password</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>

        <!-- Password -->
        <div>
            <label for="password" class="label">Password</label>
            <input id="password" class="input block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            @error('password')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn-primary w-full justify-center">
                Confirm
            </button>
        </div>
    </form>
</x-guest-layout>

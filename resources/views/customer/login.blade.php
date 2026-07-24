<x-guest-layout>

    <form method="POST" action="{{ route('customer.login.post') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">

            <a
                href="{{ route('customer.register') }}"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
                Belum punya akun?
            </a>

            <x-primary-button>
                Login
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>
<section class="min-h-screen bg-white flex flex-col items-center justify-center px-4 py-10">
    <!-- Logo sus -->
    <div class="flex flex-col items-center mb-10 select-none">
        <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-4xl">
            T
        </div>
        <span class="text-3xl font-extrabold text-gray-900 mt-2">TapLaMasa</span>
    </div>

    <!-- Formular login -->
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg border border-gray-200">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-900">Autentificare TapLaMasa</h2>

        <form wire:submit.prevent="login" class="space-y-6">
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input
                    type="email"
                    id="email"
                    wire:model="email"
                    placeholder="Introdu email-ul"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                />
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-2">Parolă</label>
                <input
                    type="password"
                    id="password"
                    wire:model="password"
                    placeholder="Introdu parola"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                />
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

{{--            <div class="flex items-center space-x-2">--}}
{{--                <input type="checkbox" id="remember" wire:model="remember" class="h-4 w-4 text-orange-500 rounded focus:ring-orange-400" />--}}
{{--                <label for="remember" class="text-gray-700 text-sm select-none">Ține-mă minte</label>--}}
{{--            </div>--}}

            <button
                type="submit"
                class="w-full bg-orange-500 text-white py-3 rounded-md font-semibold hover:bg-orange-600 transition"
            >
                Autentificare
            </button>
        </form>

{{--        <p class="mt-6 text-center text-gray-600">--}}
{{--            Nu ai cont?--}}
{{--            <a href="/register" class="text-orange-500 font-semibold hover:underline">Înregistrează-te</a>--}}
{{--        </p>--}}
    </div>
</section>

<section class="min-h-screen bg-white flex flex-col items-center justify-center px-4 py-10">
    <!-- Logo sus -->
    <div class="flex flex-col items-center mb-10 select-none">
        <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-4xl">
            T
        </div>
        <span class="text-3xl font-extrabold text-gray-900 mt-2">TapLaMasa</span>
    </div>

    <!-- Formular înregistrare -->
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg border border-gray-200">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Înregistrare</h2>
            <p class="mt-2 text-gray-600">Creează un cont nou pentru TapLaMasa</p>
        </div>

        <form wire:submit.prevent="register" class="space-y-6">
            <!-- Nume -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nume complet</label>
                <input
                    type="text"
                    id="name"
                    wire:model="name"
                    placeholder="Introdu numele complet"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                />
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">Adresa de email</label>
                <input
                    type="email"
                    id="email"
                    wire:model="email"
                    placeholder="exemplu@email.com"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                />
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Telefon (opțional) -->
            <div>
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Telefon (opțional)</label>
                <input
                    type="tel"
                    id="phone"
                    wire:model="phone"
                    placeholder="0712345678"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                />
                @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Rol -->
            <div>
                <label for="role" class="block text-gray-700 font-semibold mb-2">Rol</label>
                <select
                    id="role"
                    wire:model="role"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                >
                    <option value="staff">Personal (Staff)</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Administrator</option>
                </select>
                @error('role') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Parolă -->
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-2">Parola</label>
                <input
                    type="password"
                    id="password"
                    wire:model="password"
                    placeholder="Minimum 6 caractere"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                />
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Confirmă parola -->
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirmă parola</label>
                <input
                    type="password"
                    id="password_confirmation"
                    wire:model="password_confirmation"
                    placeholder="Repetă parola"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                />
                @error('password_confirmation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Buton înregistrare -->
            <div>
                <button
                    type="submit"
                    class="w-full bg-orange-500 text-white py-3 rounded-md font-semibold hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105"
                >
                    Creează cont
                </button>
            </div>
        </form>

        <!-- Link către login -->
        <div class="mt-6 text-center">
            <p class="text-gray-600">
                Ai deja un cont?
                <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-semibold hover:underline">
                    Autentifică-te aici
                </a>
            </p>
        </div>
    </div>
</section>

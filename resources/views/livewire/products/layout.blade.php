<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TapLaMasa - Restaurant Manager</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex flex-col">
<header class="flex flex-col items-center py-4 select-none">
    <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-4xl">
        T
    </div>
    <h1 class="text-4xl font-extrabold text-gray-900 mt-2">TapLaMasa</h1>
    <p class="text-xl text-gray-600 mt-0.5">Gestionare Produse Restaurant</p>
    <p>Bun venit, {{ auth()->user()->name }}!</p>
    <div class="w-24 h-1 bg-orange-500 rounded-full mt-3"></div>
    <div class="mt-3">
        @livewire('auth.logout')
    </div>
</header>

<!-- Container principal -->
<main class="flex-grow bg-white rounded-2xl shadow-xl max-w-6xl mx-auto w-full p-6">
    <livewire:products.product-manager />
</main>

<!-- Footer -->
<footer class="text-center py-3 text-gray-500 select-none">
    © 2025 TapLaMasa - Restaurant Management System
</footer>

@livewireScripts
</body>
</html>

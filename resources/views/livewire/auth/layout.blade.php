<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TapLaMasa' }}</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    .loader {
        border-top-color: #f97316; /* orange-500 */
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
<body class="bg-gray-50">
{{ $slot }}
@livewireScripts
</body>
</html>

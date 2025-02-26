<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="flex h-screen">
    <livewire:toast-handler />

    @include('layouts.navigation')

    <main class="flex-1 text-neutral4 ml-80">
        @if (isset($header))
            <header class="text-3xl shadow  font-medium 2xl:pt-8">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif
        <div class="">
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('status'))
                let statusData = @json(session('status')); // Convertir el array de sesión a JSON
                console.log(statusData.message); // Depuración en consola
                console.log(statusData.class);

                // Check if message and class are not null or empty
                if (statusData.message && statusData.class) {
                    Livewire.dispatch('show-toast', [{
                        message: statusData.message, // Mensaje que se mostrará en el toast
                        class: statusData.class // Clase CSS asociada al toast
                    }]);
                }
            @endif
        });
    </script>

</body>

</html>

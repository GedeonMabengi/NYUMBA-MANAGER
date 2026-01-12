<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Espace Bailleur')</title>

    @vite('resources/css/app.css')

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-gray-100 min-h-screen">

    <div class="flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-lg min-h-screen hidden md:block">
            <div class="p-6 text-xl font-bold text-blue-600">
                NYUMBA
            </div>

            <nav class="px-4 space-y-2">

                <a href="{{ route('bailleur.dashboard') }}"
                   class="block px-4 py-2 rounded hover:bg-blue-50 text-gray-700">
                    Dashboard
                </a>

                <a href="{{ route('bailleur.rentals.index') }}"
                   class="block px-4 py-2 rounded hover:bg-blue-50 text-gray-700">
                    Locations
                </a>

                <a href="{{ route('bailleur.properties.index') }}"
                   class="block px-4 py-2 rounded hover:bg-blue-50 text-gray-700">
                    Biens
                </a>

                <a href="{{ route('logout') }}"
                   class="block px-4 py-2 rounded hover:bg-red-50 text-red-600">
                    Déconnexion
                </a>

            </nav>
        </aside>

        {{-- Contenu principal --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</body>
</html>

{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Immobilière')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex justify-center items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center glass-effect">
                            <i class="fas fa-home text-purple-600 text-2xl"></i>
                        </div>
                            <h1 class="text-3xl font-bold logo-text">NYUMBA MANAGER</h1>
                        </div>
                    
                    @auth
                        <div class="hidden md:flex ml-10 space-x-4">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Tableau de bord
                                </a>
                                <a href="{{ route('admin.property-types.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Types de biens
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Utilisateurs
                                </a>
                            @elseif(auth()->user()->isBailleur())
                                <a href="{{ route('bailleur.dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Tableau de bord
                                </a>
                                <a href="{{ route('bailleur.properties.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Mes biens
                                </a>
                                <a href="{{ route('bailleur.tenants.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Locataires
                                </a>
                                <a href="{{ route('bailleur.rentals.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Locations
                                </a>
                                <a href="{{ route('bailleur.avocats.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Mes avocats
                                </a>
                            @elseif(auth()->user()->isAvocat())
                                <a href="{{ route('avocat.dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Tableau de bord
                                </a>
                                <a href="{{ route('avocat.bailleurs.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                                    Mes clients
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        {{-- Notifications --}}
                        <div class="relative">
                            <a href="{{ route('notifications.index') }}" class="text-gray-600 hover:text-indigo-600 relative">
                                <i class="fas fa-bell text-xl"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-700">{{ auth()->user()->name }}</span>
                            <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                        
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-600">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-white border-t mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500">
            &copy; {{ date('Y') }} GestImmo - Système de Gestion Immobilière
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
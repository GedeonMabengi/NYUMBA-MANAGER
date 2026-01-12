<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            }
        
            body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f0f4f8 100%);
            overflow-x: hidden;
            color: #1a202c;
            }
        
            .glass-effect {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            }
        
            .gradient-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.5;
            z-index: 0;
            animation: float 15s infinite ease-in-out;
            }
        
            .circle-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            width: 300px;
            height: 300px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
            }
        
            .circle-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            width: 250px;
            height: 250px;
            bottom: 15%;
            right: 8%;
            animation-delay: 3s;
            }
        
            .circle-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            width: 200px;
            height: 200px;
            top: 60%;
            left: 15%;
            animation-delay: 6s;
            }
        
            @keyframes float {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-20px) scale(1.05);
            }
            }
        
            .feature-card {
            transition: all 0.3s ease;
            }
        
            .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }
        
            .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            }
        
            .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            }
        
            .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            }
        
            .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            }
        
            .logo-text {
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            }
        
            .user-type-card {
            transition: all 0.3s ease;
            }
        
            .user-type-card:hover {
            transform: scale(1.05);
            }
        
            .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.8s forwards;
            }
        
            @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
            }
        
            .delay-1 {
            animation-delay: 0.2s;
            }
        
            .delay-2 {
            animation-delay: 0.4s;
            }
        
            .delay-3 {
            animation-delay: 0.6s;
            }
        
            .delay-4 {
            animation-delay: 0.8s;
            }
        
            .delay-5 {
            animation-delay: 1s;
            }
        </style>

        <title inertia>NYUMBA MANAGER | Home</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css'])
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="relative">
    <!-- Cercles décoratifs animés -->
    <div class="gradient-circle circle-1"></div>
    <div class="gradient-circle circle-2"></div>
    <div class="gradient-circle circle-3"></div>
    
    <!-- Navigation -->
    <nav class="relative z-10 py-6 px-6 md:px-12">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="/" class="flex items-center space-x-2 group">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center glass-effect group-hover:scale-105 transition-transform">
                <i class="fas fa-home text-purple-600 text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold logo-text">NYUMBA MANAGER</h1>
        </a>
        
        <!-- Navigation Links - Desktop -->
        <div class="hidden md:flex space-x-8">
            <a href="#features" class="font-medium hover:text-purple-600 transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-purple-600 after:transition-all hover:after:w-full">
                Fonctionnalités
            </a>
            <a href="#users" class="font-medium hover:text-purple-600 transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-purple-600 after:transition-all hover:after:w-full">
                Pour Qui?
            </a>
            <a href="#about" class="font-medium hover:text-purple-600 transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-purple-600 after:transition-all hover:after:w-full">
                À Propos
            </a>
        </div>
        
        <!-- Auth Buttons -->
        <div class="hidden md:flex items-center space-x-4">
            @auth
                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button 
                        @click="open = !open" 
                        @click.outside="open = false"
                        class="flex items-center space-x-2 btn-secondary px-4 py-2 rounded-lg font-semibold glass-effect hover:shadow-lg transition-all"
                    >
                        <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white text-sm font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-purple-100 text-purple-600">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute right-0 mt-2 w-56 rounded-xl glass-effect shadow-xl border border-white/20 overflow-hidden"
                    >
                        <div class="py-2">
                            @php
                                $dashboardRoute = match(Auth::user()->role) {
                                    'admin' => route('admin.dashboard'),
                                    'bailleur' => route('bailleur.dashboard'),
                                    'avocat' => route('avocat.dashboard'),
                                    default => '#'
                                };
                            @endphp
                            
                            <a href="{{ $dashboardRoute }}" class="flex items-center px-4 py-3 hover:bg-purple-50 transition-colors">
                                <i class="fas fa-tachometer-alt w-5 text-purple-600"></i>
                                <span class="ml-3">Tableau de bord</span>
                            </a>
                            
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 hover:bg-purple-50 transition-colors">
                                <i class="fas fa-user-cog w-5 text-purple-600"></i>
                                <span class="ml-3">Mon Profil</span>
                            </a>
                            
                            <hr class="my-2 border-gray-200">
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-3 hover:bg-red-50 transition-colors text-red-600">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span class="ml-3">Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-lg font-semibold text-purple-600 hover:bg-purple-50 transition-colors">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-lg font-semibold bg-gradient-to-r from-purple-600 to-indigo-600 text-purple-900 hover:shadow-lg hover:scale-105 transition-all">
                    S'inscrire
                </a>
            @endauth
        </div>
        
        <!-- Mobile Menu Button -->
        <button 
            class="md:hidden p-2 rounded-lg glass-effect"
            x-data
            @click="$dispatch('toggle-mobile-menu')"
        >
            <i class="fas fa-bars text-xl text-purple-600"></i>
        </button>
    </div>
    
    <!-- Mobile Menu -->
    <div 
        x-data="{ open: false }"
        @toggle-mobile-menu.window="open = !open"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden mt-4 p-4 rounded-2xl glass-effect"
    >
        <div class="flex flex-col space-y-4">
            <a href="#features" class="font-medium py-2 hover:text-purple-600 transition-colors">Fonctionnalités</a>
            <a href="#users" class="font-medium py-2 hover:text-purple-600 transition-colors">Pour Qui?</a>
            <a href="#about" class="font-medium py-2 hover:text-purple-600 transition-colors">À Propos</a>
            
            <hr class="border-gray-200">
            
            @auth
                <div class="flex items-center space-x-3 py-2">
                    <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                </div>
                
                @php
                    $dashboardRoute = match(Auth::user()->role) {
                        'admin' => route('admin.dashboard'),
                        'bailleur' => route('bailleur.dashboard'),
                        'avocat' => route('avocat.dashboard'),
                        default => '#'
                    };
                @endphp
                
                <a href="{{ $dashboardRoute }}" class="flex items-center py-2 text-purple-600">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="ml-3">Tableau de bord</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center py-2 text-red-600">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span class="ml-3">Déconnexion</span>
                    </button>
                </form>
            @else
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('login') }}" class="w-full text-center px-6 py-3 rounded-lg font-semibold border-2 border-purple-600 text-purple-600 hover:bg-purple-50 transition-colors">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="w-full text-center px-6 py-3 rounded-lg font-semibold bg-gradient-to-r from-purple-800 to-indigo-600 text-black">
                        S'inscrire
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
    
    <!-- Hero Section -->
    <section class="relative z-10 py-16 md:py-24 px-6 md:px-12">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto text-center fade-in">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Gérez vos <span class="logo-text">biens immobiliers</span> et mobiliers en toute simplicité
                </h1>
                <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                    Un système complet de gestion pour bailleurs et leurs avocats, avec suivi des locataires, notifications automatiques et gestion documentaire.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <button class="btn-primary px-8 py-4 rounded-lg font-semibold text-white">
                        Démarrer gratuitement <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                    <button class="px-8 py-4 rounded-lg font-semibold glass-effect">
                        Voir une démo <i class="fas fa-play-circle ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section id="features" class="relative z-10 py-16 px-6 md:px-12 bg-white bg-opacity-30">
        <div class="container mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-16 fade-in">Fonctionnalités principales</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card p-8 rounded-2xl glass-effect fade-in delay-1">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center bg-gradient-to-br from-purple-100 to-pink-100 mb-6">
                        <i class="fas fa-home text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Gestion des biens</h3>
                    <p class="text-gray-600 mb-4">
                        Ajoutez et gérez tous vos biens immobiliers et mobiliers. Définissez le type, la localisation et les caractéristiques de chaque bien.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Types personnalisables</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Localisations précises</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Gestion multi-bailleurs</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card p-8 rounded-2xl glass-effect fade-in delay-2">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-100 mb-6">
                        <i class="fas fa-users text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Gestion des locataires</h3>
                    <p class="text-gray-600 mb-4">
                        Attribuez des locataires à vos biens, enregistrez leurs informations et stockez les contrats de bail numériquement.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Fiches locataires complètes</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Upload de contrats</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Capture de photos</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card p-8 rounded-2xl glass-effect fade-in delay-3">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 mb-6">
                        <i class="fas fa-bell text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Notifications automatiques</h3>
                    <p class="text-gray-600 mb-4">
                        Les avocats reçoivent des notifications en temps réel pour chaque événement important concernant les biens de leurs clients.
                    </p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Notifications par email</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Suivi des 3 événements majeurs</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Multiples avocats par bailleur</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- User Types Section -->
    <section id="users" class="relative z-10 py-16 px-6 md:px-12">
        <div class="container mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-16 fade-in">Conçu pour deux types d'utilisateurs</h2>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Bailleur Card -->
                <div class="user-type-card p-8 rounded-2xl glass-effect fade-in delay-4">
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center bg-gradient-to-br from-purple-500 to-pink-500 mr-4">
                            <i class="fas fa-user-tie text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold">Bailleurs</h3>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Gérez efficacement votre parc immobilier et mobilier. Ajoutez des biens, attribuez des locataires et conservez tous vos documents au même endroit.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                <i class="fas fa-plus text-purple-600"></i>
                            </div>
                            <span>Ajout et enregistrement des biens</span>
                        </li>
                        <li class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-purple-600"></i>
                            </div>
                            <span>Gestion des localisations</span>
                        </li>
                        <li class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                <i class="fas fa-file-contract text-purple-600"></i>
                            </div>
                            <span>Attribution de locataires avec contrats</span>
                        </li>
                    </ul>
                    <button class="w-full py-3 rounded-lg font-semibold bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                        En savoir plus pour les bailleurs
                    </button>
                </div>
                
                <!-- Avocat Card -->
                <div class="user-type-card p-8 rounded-2xl glass-effect fade-in delay-5">
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-cyan-500 mr-4">
                            <i class="fas fa-balance-scale text-2xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold">Avocats</h3>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Restez informé de toutes les actions concernant les biens de vos clients. Recevez des notifications pour chaque événement important.
                    </p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-bell text-blue-600"></i>
                            </div>
                            <span>Notifications en temps réel</span>
                        </li>
                        <li class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>
                            <span>Alertes par email systématiques</span>
                        </li>
                        <li class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-eye text-blue-600"></i>
                            </div>
                            <span>Suivi des 3 événements majeurs</span>
                        </li>
                    </ul>
                    <button class="w-full py-3 rounded-lg font-semibold bg-gradient-to-r from-blue-500 to-cyan-500 text-white">
                        En savoir plus pour les avocats
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section id="about" class="relative z-10 py-16 px-6 md:px-12">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto text-center rounded-3xl p-8 md:p-12 glass-effect fade-in">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Prêt à simplifier votre gestion immobilière?</h2>
                <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                    Rejoignez les centaines de bailleurs et d'avocats qui utilisent déjà ImmoGest pour gérer leurs biens en toute tranquillité.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <button class="btn-primary px-8 py-4 rounded-lg font-semibold text-white">
                        Créer un compte gratuit <i class="fas fa-user-plus ml-2"></i>
                    </button>
                    <button class="px-8 py-4 rounded-lg font-semibold glass-effect">
                        Contacter nos experts <i class="fas fa-comment-dots ml-2"></i>
                    </button>
                </div>
                <p class="mt-8 text-gray-500">Essai gratuit de 30 jours • Aucune carte de crédit requise</p>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="relative z-10 py-8 px-6 md:px-12 border-t border-gray-200 border-opacity-30">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center glass-effect">
                        <i class="fas fa-home text-purple-600"></i>
                    </div>
                    <h1 class="text-xl font-bold logo-text">ImmoGest</h1>
                </div>
                
                <div class="flex space-x-6 mb-4 md:mb-0">
                    <a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">
                        <i class="fab fa-facebook"></i>
                    </a>
                </div>
                
                <div class="text-gray-500 text-sm">
                    &copy; 2023 ImmoGest. Tous droits réservés.
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        // Animation au défilement
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            
            const fadeInOnScroll = function() {
                fadeElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.style.opacity = "1";
                        element.style.transform = "translateY(0)";
                    }
                });
            };
            
            // Déclenche une première fois pour les éléments déjà visibles
            fadeInOnScroll();
            
            // Écoute l'événement de défilement
            window.addEventListener('scroll', fadeInOnScroll);
            
            // Animation des cercles
            const circles = document.querySelectorAll('.gradient-circle');
            circles.forEach((circle, index) => {
                // L'animation est déjà définie dans CSS
                // Ajout d'un léger délai aléatoire pour chaque cercle
                const randomDelay = Math.random() * 5;
                circle.style.animationDelay = `${randomDelay}s`;
            });
            
            // Gestion des clics sur les boutons
            document.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', function() {
                    // Effet de clic visuel
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                    
                    // Simulation d'action
                    if (this.textContent.includes('Démarrer') || this.textContent.includes('Créer')) {
                        alert("Page d'inscription en cours de chargement...");
                    } else if (this.textContent.includes('démo')) {
                        alert("Démarrage de la démonstration du système...");
                    }
                });
            });
        });
    </script>
</body>
</html>

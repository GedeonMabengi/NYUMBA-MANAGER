@extends('layouts.guest')

@section('title', 'Connexion - NYUMBA MANAGER')

@section('content')
<div class="relative min-h-screen flex items-center justify-center px-4">
    <!-- Cercles décoratifs animés -->
    <div class="gradient-circle circle-1"></div>
    <div class="gradient-circle circle-2"></div>
    <div class="gradient-circle circle-3"></div>
    
    <!-- Container principal -->
    <div class="relative z-10 w-full max-w-md fade-in">
        <!-- Logo et titre -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center space-x-3 mb-4">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center glass-effect">
                    <i class="fas fa-home text-purple-600 text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold logo-text">NYUMBA MANAGER</h1>
            </div>
            <h2 class="text-xl text-gray-600">Connectez-vous à votre compte</h2>
        </div>
        
        <!-- Carte du formulaire -->
        <div class="glass-effect p-8 rounded-2xl shadow-xl">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="fade-in delay-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2"></i>Adresse email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 
                                   focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent
                                    placeholder-gray-400
                                   transition-all duration-200 bg-white/50 backdrop-blur-sm">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="fade-in delay-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>Mot de passe
                    </label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 
                                   focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent
                                 placeholder-gray-400
                                   transition-all duration-200 bg-white/50 backdrop-blur-sm">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between fade-in delay-3">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded 
                                   transition duration-200 cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                            Se souvenir de moi
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" 
                           class="font-medium text-purple-600 hover:text-purple-500 transition-colors duration-200">
                            Mot de passe oublié ?
                        </a>
                    </div>
                </div>

                <!-- Bouton de connexion -->
                <div class="fade-in delay-4">
                    <button type="submit"
                        class="w-full flex justify-center items-center py-3 px-4 rounded-lg shadow-sm 
                               text-sm font-medium text-white btn-primary transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se connecter
                    </button>
                </div>
            </form>

            <!-- Séparateur -->
            <div class="mt-8 fade-in delay-5">
                <div class="relative">
                    <div class="absolute inset-0 -bottom-5 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-transparent text-gray-500 dark:text-gray-400">
                            Nouveau sur NYUMBA MANAGER ?
                        </span>
                    </div>
                </div>

                <!-- Bouton d'inscription -->
                <div class="mt-6">
                    <a href="{{ route('register') }}"
                        class="w-full flex justify-center items-center py-3 px-4 rounded-lg 
                               text-sm font-medium text-gray-700 dark:text-gray-300 
                               glass-effect hover:bg-white/30 transition-all duration-200
                               border border-gray-300 dark:border-gray-600">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer un compte
                    </a>
                </div>
            </div>

            <!-- Retour à l'accueil -->
            <div class="mt-6 text-center fade-in delay-5">
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center text-sm text-gray-600 hover:text-purple-600 
                          transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Styles spécifiques à la page login -->
<style>
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

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .logo-text {
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
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

    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }
    .delay-3 { animation-delay: 0.6s; }
    .delay-4 { animation-delay: 0.8s; }
    .delay-5 { animation-delay: 1s; }

    /* Styles pour les inputs au focus */
    input:focus {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Effet de hover pour les liens */
    a:hover {
        transform: translateY(-2px);
    }
</style>

<!-- Script pour les animations -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des cercles
        const circles = document.querySelectorAll('.gradient-circle');
        circles.forEach((circle, index) => {
            const randomDelay = Math.random() * 5;
            circle.style.animationDelay = `${randomDelay}s`;
        });

        // Effet de focus amélioré pour les inputs
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"], input[type="text"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-purple-300', 'rounded-lg');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-purple-300', 'rounded-lg');
            });
        });

        // Effet de hover pour le bouton de connexion
        const loginBtn = document.querySelector('button[type="submit"]');
        loginBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        loginBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });

        // Effet de clic pour les boutons
        const buttons = document.querySelectorAll('button, a.btn-primary');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    if (this.type !== 'submit') {
                        this.style.transform = '';
                    }
                }, 150);
            });
        });
    });
</script>
@endsection
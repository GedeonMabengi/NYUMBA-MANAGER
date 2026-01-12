import React, { useEffect } from 'react';
import { Head } from '@inertiajs/react';

export default function Welcome() {
    useEffect(() => {
        // Logique d'animation au défilement (Fade In)
        const fadeElements = document.querySelectorAll('.fade-in-element');
        
        const fadeInOnScroll = () => {
            fadeElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('is-visible');
                }
            });
        };

        window.addEventListener('scroll', fadeInOnScroll);
        // Déclenchement initial pour les éléments déjà visibles
        fadeInOnScroll();

        return () => window.removeEventListener('scroll', fadeInOnScroll);
    }, []);

    const handleButtonClick = (text) => {
        if (text.includes('Démarrer') || text.includes('Créer')) {
            alert("Page d'inscription en cours de chargement...");
        } else if (text.includes('démo')) {
            alert("Démarrage de la démonstration du système...");
        }
    };

    return (
        <div className="relative overflow-x-hidden bg-[#f5f7fa] text-[#1a202c] font-['Inter',_sans-serif] min-h-screen">
            <Head>
                <title>ImmoGest | Gestion Immobilière Intelligente</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
                <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
                <style>{`
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
                        0%, 100% { transform: translateY(0) scale(1); }
                        50% { transform: translateY(-20px) scale(1.05); }
                    }
                    
                    .feature-card { transition: all 0.3s ease; }
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
                    
                    .user-type-card { transition: all 0.3s ease; }
                    .user-type-card:hover { transform: scale(1.05); }
                    
                    .fade-in-element {
                        opacity: 0;
                        transform: translateY(20px);
                        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
                    }
                    
                    .fade-in-element.is-visible {
                        opacity: 1;
                        transform: translateY(0);
                    }

                    .delay-1 { transition-delay: 0.2s; }
                    .delay-2 { transition-delay: 0.4s; }
                    .delay-3 { transition-delay: 0.6s; }
                    .delay-4 { transition-delay: 0.8s; }
                    .delay-5 { transition-delay: 1s; }
                `}</style>
            </Head>

            {/* Cercles décoratifs animés */}
            <div className="gradient-circle circle-1"></div>
            <div className="gradient-circle circle-2"></div>
            <div className="gradient-circle circle-3"></div>

            {/* Navigation */}
            <nav className="relative z-10 py-6 px-6 md:px-12">
                <div className="container mx-auto flex justify-between items-center">
                    <div className="flex items-center space-x-2">
                        <div className="w-10 h-10 rounded-lg flex items-center justify-center glass-effect">
                            <i className="fas fa-home text-purple-600 text-xl"></i>
                        </div>
                        <h1 className="text-2xl font-bold logo-text">ImmoGest</h1>
                    </div>
                    
                    <div className="hidden md:flex space-x-8">
                        <a href="#features" className="font-medium hover:text-purple-600 transition-colors">Fonctionnalités</a>
                        <a href="#users" className="font-medium hover:text-purple-600 transition-colors">Pour Qui?</a>
                        <a href="#about" className="font-medium hover:text-purple-600 transition-colors">À Propos</a>
                    </div>
                    
                    <div>
                        <a href='/login' className="btn-secondary px-6 py-3 rounded-lg font-semibold glass-effect">Se Connecter</a>
                        <a href='/register' className="btn-secondary px-6 py-3 rounded-lg font-semibold glass-effect">S'inscrire</a>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <section className="relative z-10 py-16 md:py-24 px-6 md:px-12">
                <div className="container mx-auto">
                    <div className="max-w-4xl mx-auto text-center fade-in-element">
                        <h1 className="text-4xl md:text-6xl font-bold mb-6">
                            Gérez vos <span className="logo-text">biens immobiliers</span> et mobiliers en toute simplicité
                        </h1>
                        <p className="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                            Un système complet de gestion pour bailleurs et leurs avocats, avec suivi des locataires, notifications automatiques et gestion documentaire.
                        </p>
                        <div className="flex flex-col sm:flex-row justify-center gap-4">
                            <button 
                                onClick={() => handleButtonClick('Démarrer')}
                                className="btn-primary px-8 py-4 rounded-lg font-semibold text-white"
                            >
                                Démarrer gratuitement <i className="fas fa-arrow-right ml-2"></i>
                            </button>
                            <button 
                                onClick={() => handleButtonClick('démo')}
                                className="px-8 py-4 rounded-lg font-semibold glass-effect"
                            >
                                Voir une démo <i className="fas fa-play-circle ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            {/* Features Section */}
            <section id="features" className="relative z-10 py-16 px-6 md:px-12 bg-white bg-opacity-30">
                <div className="container mx-auto">
                    <h2 className="text-3xl md:text-4xl font-bold text-center mb-16 fade-in-element">Fonctionnalités principales</h2>
                    
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {/* Feature 1 */}
                        <div className="feature-card p-8 rounded-2xl glass-effect fade-in-element delay-1">
                            <div className="w-16 h-16 rounded-xl flex items-center justify-center bg-gradient-to-br from-purple-100 to-pink-100 mb-6">
                                <i className="fas fa-home text-2xl text-purple-600"></i>
                            </div>
                            <h3 className="text-xl font-bold mb-4">Gestion des biens</h3>
                            <p className="text-gray-600 mb-4">
                                Ajoutez et gérez tous vos biens immobiliers et mobiliers. Définissez le type, la localisation et les caractéristiques de chaque bien.
                            </p>
                            <ul className="space-y-2 text-gray-600">
                                <li className="flex items-center">
                                    <i className="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Types personnalisables</span>
                                </li>
                                <li className="flex items-center">
                                    <i className="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Localisations précises</span>
                                </li>
                                <li className="flex items-center">
                                    <i className="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Gestion multi-bailleurs</span>
                                </li>
                            </ul>
                        </div>

                        {/* Feature 2 */}
                        <div className="feature-card p-8 rounded-2xl glass-effect fade-in-element delay-2">
                            <div className="w-16 h-16 rounded-xl flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-100 mb-6">
                                <i className="fas fa-users text-2xl text-blue-600"></i>
                            </div>
                            <h3 className="text-xl font-bold mb-4">Gestion des locataires</h3>
                            <p className="text-gray-600 mb-4">
                                Attribuez des locataires à vos biens, enregistrez leurs informations et stockez les contrats de bail numériquement.
                            </p>
                            <ul className="space-y-2 text-gray-600">
                                <li className="flex items-center">
                                    <i className="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Fiches locataires complètes</span>
                                </li>
                                <li className="flex items-center">
                                    <i className="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Upload de contrats</span>
                                </li>
                                <li className="flex items-center">
                                    <i className="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Capture de photos</span>
                                </li>
                            </ul>
                        </div>

                        {/* Feature 3 */}
                        <div className="feature-card p-8 rounded-2xl glass-effect fade-in-element delay-3">
                            <div className="w-16 h-16 rounded-xl flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 mb-6">
                                <i className="fas fa-bell text-2xl text-green-600"></i>
                            </div>
                            <h3 className="text-xl font-bold mb-4">Notifications automatiques</h3>
                            <p className="text-gray-600 mb-4">
                                Les avocats reçoivent des notifications en temps réel pour chaque événement important concernant les biens de leurs clients.
                            </p>
                            <ul className="space-y-2 text-gray-600">
                                <li className="flex items-center">
                                    <i className="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Notifications par email</span>
                                </li>
                                <li className="flex items-center">
                                    <i className="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Suivi des 3 événements majeurs</span>
                                </li>
                                <li className="flex items-center">
                                    <i className="fas fa-check-circle text-green-500 mr-2"></i>
                                    <span>Multiples avocats par bailleur</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {/* User Types Section */}
            <section id="users" className="relative z-10 py-16 px-6 md:px-12">
                <div className="container mx-auto">
                    <h2 className="text-3xl md:text-4xl font-bold text-center mb-16 fade-in-element">Conçu pour deux types d'utilisateurs</h2>
                    
                    <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                        {/* Bailleur Card */}
                        <div className="user-type-card p-8 rounded-2xl glass-effect fade-in-element delay-4">
                            <div className="flex items-center mb-6">
                                <div className="w-14 h-14 rounded-full flex items-center justify-center bg-gradient-to-br from-purple-500 to-pink-500 mr-4">
                                    <i className="fas fa-user-tie text-2xl text-white"></i>
                                </div>
                                <h3 className="text-2xl font-bold">Bailleurs</h3>
                            </div>
                            <p className="text-gray-600 mb-6">
                                Gérez efficacement votre parc immobilier et mobilier. Ajoutez des biens, attribuez des locataires et conservez tous vos documents au même endroit.
                            </p>
                            <ul className="space-y-3 mb-8">
                                <li className="flex items-center">
                                    <div className="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                        <i className="fas fa-plus text-purple-600"></i>
                                    </div>
                                    <span>Ajout et enregistrement des biens</span>
                                </li>
                                <li className="flex items-center">
                                    <div className="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                        <i className="fas fa-map-marker-alt text-purple-600"></i>
                                    </div>
                                    <span>Gestion des localisations</span>
                                </li>
                                <li className="flex items-center">
                                    <div className="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                        <i className="fas fa-file-contract text-purple-600"></i>
                                    </div>
                                    <span>Attribution de locataires avec contrats</span>
                                </li>
                            </ul>
                            <button className="w-full py-3 rounded-lg font-semibold bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                                En savoir plus pour les bailleurs
                            </button>
                        </div>

                        {/* Avocat Card */}
                        <div className="user-type-card p-8 rounded-2xl glass-effect fade-in-element delay-5">
                            <div className="flex items-center mb-6">
                                <div className="w-14 h-14 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-cyan-500 mr-4">
                                    <i className="fas fa-balance-scale text-2xl text-white"></i>
                                </div>
                                <h3 className="text-2xl font-bold">Avocats</h3>
                            </div>
                            <p className="text-gray-600 mb-6">
                                Restez informé de toutes les actions concernant les biens de vos clients. Recevez des notifications pour chaque événement important.
                            </p>
                            <ul className="space-y-3 mb-8">
                                <li className="flex items-center">
                                    <div className="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <i className="fas fa-bell text-blue-600"></i>
                                    </div>
                                    <span>Notifications en temps réel</span>
                                </li>
                                <li className="flex items-center">
                                    <div className="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <i className="fas fa-envelope text-blue-600"></i>
                                    </div>
                                    <span>Alertes par email systématiques</span>
                                </li>
                                <li className="flex items-center">
                                    <div className="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <i className="fas fa-eye text-blue-600"></i>
                                    </div>
                                    <span>Suivi des 3 événements majeurs</span>
                                </li>
                            </ul>
                            <button className="w-full py-3 rounded-lg font-semibold bg-gradient-to-r from-blue-500 to-cyan-500 text-white">
                                En savoir plus pour les avocats
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            {/* CTA Section */}
            <section id="about" className="relative z-10 py-16 px-6 md:px-12">
                <div className="container mx-auto">
                    <div className="max-w-4xl mx-auto text-center rounded-3xl p-8 md:p-12 glass-effect fade-in-element">
                        <h2 className="text-3xl md:text-4xl font-bold mb-6">Prêt à simplifier votre gestion immobilière?</h2>
                        <p className="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                            Rejoignez les centaines de bailleurs et d'avocats qui utilisent déjà ImmoGest pour gérer leurs biens en toute tranquillité.
                        </p>
                        <div className="flex flex-col sm:flex-row justify-center gap-4">
                            <button 
                                onClick={() => handleButtonClick('Créer')}
                                className="btn-primary px-8 py-4 rounded-lg font-semibold text-white"
                            >
                                Créer un compte gratuit <i className="fas fa-user-plus ml-2"></i>
                            </button>
                            <button className="px-8 py-4 rounded-lg font-semibold glass-effect">
                                Contacter nos experts <i className="fas fa-comment-dots ml-2"></i>
                            </button>
                        </div>
                        <p className="mt-8 text-gray-500">Essai gratuit de 30 jours • Aucune carte de crédit requise</p>
                    </div>
                </div>
            </section>

            {/* Footer */}
            <footer className="relative z-10 py-8 px-6 md:px-12 border-t border-gray-200 border-opacity-30">
                <div className="container mx-auto">
                    <div className="flex flex-col md:flex-row justify-between items-center">
                        <div className="flex items-center space-x-2 mb-4 md:mb-0">
                            <div className="w-8 h-8 rounded-lg flex items-center justify-center glass-effect">
                                <i className="fas fa-home text-purple-600"></i>
                            </div>
                            <h1 className="text-xl font-bold logo-text">ImmoGest</h1>
                        </div>
                        
                        <div className="flex space-x-6 mb-4 md:mb-0">
                            <a href="#" className="text-gray-600 hover:text-purple-600 transition-colors">
                                <i className="fab fa-twitter"></i>
                            </a>
                            <a href="#" className="text-gray-600 hover:text-purple-600 transition-colors">
                                <i className="fab fa-linkedin"></i>
                            </a>
                            <a href="#" className="text-gray-600 hover:text-purple-600 transition-colors">
                                <i className="fab fa-facebook"></i>
                            </a>
                        </div>
                        
                        <div className="text-gray-500 text-sm">
                            &copy; 2026 ImmoGest. Tous droits réservés.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    );
}
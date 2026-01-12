import { Head } from '@inertiajs/react';
import { useState, useEffect } from 'react';

export default function Dashboard() {
    // États pour les données dynamiques
    const [userName, setUserName] = useState("Honoré");
    const [userLevel, setUserLevel] = useState("3ème secondaire");
    const [globalProgress, setGlobalProgress] = useState(45);
    const [studyTime, setStudyTime] = useState("5h 30m");
    const [averageScore, setAverageScore] = useState(88);

    // Simulation de chargement de données (à remplacer par un appel API réel)
    useEffect(() => {
        // Exemple : Récupérer les données depuis une API ou un contexte
        // fetchData();
    }, []);

    return (
        <>
            <Head title="Tableau de bord - ALCHIFUNDA" />

            {/* Container principal */}
            <div className="flex items-center justify-center min-h-screen px-4 py-8 bg-gradient-to-br from-blue-50 to-indigo-100">
                <div className="w-full max-w-4xl">

                    {/* En-tête */}
                    <div className="flex justify-between items-center mb-8">
                        <div className="flex items-center">
                            <div className="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-full mr-4">
                                <svg className="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 className="text-3xl font-bold text-gray-800">Bonjour, <span className="text-indigo-600">{userName}</span> !</h1>
                                <p className="text-gray-600">Voici votre tableau de bord.</p>
                            </div>
                        </div>
                        <div className="text-right">
                            <p className="text-gray-700 font-medium">Niveau actuel : <span className="text-indigo-600 font-bold">{userLevel}</span></p>
                        </div>
                    </div>

                    {/* Cartes de progression */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        {/* Progression globale */}
                        <div className="bg-white rounded-xl shadow-md p-6">
                            <h3 className="text-lg font-semibold text-gray-800 mb-4">Progression globale</h3>
                            <div className="w-full bg-indigo-100 rounded-full h-2.5 mb-2">
                                <div className="bg-indigo-600 h-2.5 rounded-full" style={{ width: `${globalProgress}%` }}></div>
                            </div>
                            <p className="text-gray-600 text-sm">{globalProgress}% complété</p>
                        </div>

                        {/* Temps d'étude */}
                        <div className="bg-white rounded-xl shadow-md p-6">
                            <h3 className="text-lg font-semibold text-gray-800 mb-4">Temps d'étude</h3>
                            <p className="text-3xl font-bold text-indigo-600 mb-2">{studyTime}</p>
                            <p className="text-gray-600 text-sm">cette semaine</p>
                        </div>

                        {/* Score moyen */}
                        <div className="bg-white rounded-xl shadow-md p-6">
                            <h3 className="text-lg font-semibold text-gray-800 mb-4">Score moyen</h3>
                            <p className="text-3xl font-bold text-indigo-600 mb-2">{averageScore}</p>
                            <p className="text-gray-600 text-sm">/100</p>
                        </div>
                    </div>

                    {/* Parcours recommandé */}
                    <div className="bg-white rounded-xl shadow-md p-6 mb-8">
                        <h2 className="text-xl font-semibold text-gray-800 mb-4">Votre parcours recommandé</h2>
                        <div className="space-y-4">
                            {/* Leçon en cours */}
                            <div className="flex items-center justify-between p-4 bg-indigo-50 rounded-lg">
                                <div className="flex items-center">
                                    <div className="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center mr-4">
                                        <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 className="font-medium text-gray-800">Les liaisons chimiques</h3>
                                        <p className="text-sm text-gray-600">En cours • 60% complété</p>
                                    </div>
                                </div>
                                <button className="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition">
                                    Continuer
                                </button>
                            </div>

                            {/* Leçon suivante */}
                            <div className="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div className="flex items-center">
                                    <div className="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mr-4">
                                        <svg className="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 className="font-medium text-gray-800">Les réactions chimiques</h3>
                                        <p className="text-sm text-gray-600">À venir</p>
                                    </div>
                                </div>
                                <button className="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium py-2 px-4 rounded-lg transition">
                                    Prévisualiser
                                </button>
                            </div>
                        </div>
                    </div>

                    {/* Statistiques détaillées */}
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {/* Activité récente */}
                        <div className="bg-white rounded-xl shadow-md p-6">
                            <h3 className="text-lg font-semibold text-gray-800 mb-4">Activité récente</h3>
                            <div className="space-y-3">
                                <div className="flex items-center">
                                    <div className="w-3 h-3 bg-indigo-600 rounded-full mr-3"></div>
                                    <p className="text-sm text-gray-700">Leçon : Les atomes (complétée)</p>
                                </div>
                                <div className="flex items-center">
                                    <div className="w-3 h-3 bg-indigo-600 rounded-full mr-3"></div>
                                    <p className="text-sm text-gray-700">Quiz : Score 85/100</p>
                                </div>
                                <div className="flex items-center">
                                    <div className="w-3 h-3 bg-indigo-600 rounded-full mr-3"></div>
                                    <p className="text-sm text-gray-700">Révisions : Les molécules</p>
                                </div>
                            </div>
                        </div>

                        {/* Prochaines révisions */}
                        <div className="bg-white rounded-xl shadow-md p-6">
                            <h3 className="text-lg font-semibold text-gray-800 mb-4">Prochaines révisions</h3>
                            <div className="space-y-3">
                                <div className="flex items-center justify-between">
                                    <p className="text-sm text-gray-700">Les atomes</p>
                                    <span className="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Dans 2 jours</span>
                                </div>
                                <div className="flex items-center justify-between">
                                    <p className="text-sm text-gray-700">Les équations chimiques</p>
                                    <span className="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Dans 5 jours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

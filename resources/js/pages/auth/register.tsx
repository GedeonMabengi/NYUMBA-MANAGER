import { login } from '@/routes';
import { store } from '@/routes/register';
import { Form, Head } from '@inertiajs/react';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';

export default function Register() {
    return (
        <>
            <Head title="S'inscrire - ALCHIFUNDA" />

            {/* Header fixe pour la navigation */}
            <header className="fixed top-0 w-full bg-white/95 shadow-sm backdrop-blur-sm z-50 py-4 px-6">
                <div className="container mx-auto flex justify-between items-center">
                    <a href='/' className="flex items-center gap-2.5 text-2xl font-bold text-[#4A3AFF]">
                        <i className="fas fa-atom text-[#00C9B7] text-3xl"></i>
                        <span>ALCHIFUNDA</span>
                    </a>
                </div>
            </header>

            {/* Contenu principal de la page d'inscription */}
            <div className="min-h-screen bg-gradient-to-br from-[#f5f7ff] to-[#eef2ff] flex items-center justify-center p-[70px_20px_40px] relative overflow-hidden">
                {/* Effets décoratifs */}
                <div className="absolute w-[300px] h-[300px] rounded-full bg-[#4A3AFF]/5 top-[-150px] right-[-150px]"></div>
                <div className="absolute w-[200px] h-[200px] rounded-full bg-[#00C9B7]/5 bottom-[-100px] left-[-100px]"></div>

                {/* Lien retour à l'accueil */}

                {/* Carte d'inscription */}
                <div className="bg-white rounded-2xl p-12 shadow-xl w-full max-w-[480px] relative z-10 border border-black/5">
                    <div className="text-center mb-10">
                        <div className="flex items-center justify-center gap-3 font-bold text-3xl text-[#4A3AFF] mb-5">
                            <i className="fas fa-atom text-[#00C9B7] text-4xl"></i>
                            ALCHIFUNDA
                        </div>
                        <h1 className="text-3xl font-semibold text-[#1A1A2E] font-serif mb-2.5">Créer un compte</h1>
                        <p className="text-gray-500">
                            Entrez vos informations pour créer votre compte et commencer à apprendre la chimie
                        </p>
                    </div>

                    <Form
                        {...store.form()}
                        resetOnSuccess={['password', 'password_confirmation']}
                        disableWhileProcessing
                    >
                        {({ processing, errors, data = {}, setData }) => (
                            <>
                                {/* Champ Nom */}
                                <div className="mb-6">
                                    <Label htmlFor="name" className='text-black'>Name</Label>
                                    <Input
                                        id="name"
                                        type="text"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        autoComplete="name"
                                        name="name"
                                        placeholder="Full name"
                                    />
                                    <InputError
                                        message={errors.name}
                                        className="mt-2"
                                    />

                                </div>

                                {/* Champ Email */}
                                <div className="mb-6">
                                    <Label htmlFor="email" className='text-black'>Email address</Label>
                                                                <Input
                                                                    id="email"
                                                                    type="email"
                                                                    required
                                                                    tabIndex={2}
                                                                    autoComplete="email"
                                                                    name="email"
                                                                    placeholder="email@example.com"
                                                                />
                                                                <InputError message={errors.email} />
                                </div>

                                {/* Champ Mot de passe */}
                                <div className="mb-6">
                                    <Label htmlFor="password" className='text-black'>Password</Label>
                                    <Input
                                                                        id="password"
                                                                        type="password"
                                                                        required
                                                                        tabIndex={3}
                                                                        autoComplete="new-password"
                                                                        name="password"
                                                                        placeholder="Password"
                                    />
                                    <InputError message={errors.password} />
                                </div>

                                {/* Champ Confirmer le mot de passe */}
                                <div className="mb-6">
                                    <Label htmlFor="password_confirmation" className='text-black'>
                                        Confirm password
                                    </Label>
                                    <Input
                                                                        id="password_confirmation"
                                                                        type="password"
                                                                        required
                                                                        tabIndex={4}
                                                                        autoComplete="new-password"
                                                                        name="password_confirmation"
                                                                        placeholder="Confirm password"
                                    />
                                    <InputError
                                                                        message={errors.password_confirmation}
                                    />
                                </div>

                                {/* Bouton de soumission */}
                                <Button
                                type="submit"
                                className="mt-2 w-full bg-blue-400"
                                tabIndex={5}
                                data-test="register-user-button"
                            >
                                {processing && <Spinner />}
                                Create account
                                </Button>
                            </>
                        )}
                    </Form>

                    {/* Lien vers la page de connexion */}
                    <div className="text-center mt-7.5 text-gray-500 text-sm">
                        Vous avez déjà un compte ?{' '}
                        <a
                            href={login()}
                            tabIndex={6}
                            className="text-[#4A3AFF] font-semibold transition-all hover:text-[#3a2ae0] hover:underline"
                        >
                            Se connecter
                        </a>
                    </div>
                </div>
            </div>

            {/* Footer */}
            <footer className="bg-[#1A1A2E] text-white py-10 px-0 text-center">
                <div className="container mx-auto px-5">
                    <div className="border-t border-white/10 pt-5 mt-5 text-white/60 text-sm">
                        <p>&copy; 2026 ALCHIFUNDA. Tous droits réservés. Conçu pour l'enseignement de la chimie en RDC.</p>
                    </div>
                </div>
            </footer>
        </>
    );
}

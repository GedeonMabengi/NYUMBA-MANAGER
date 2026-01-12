import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
// import { register } from '@/routes/register';
import { Form, Head } from '@inertiajs/react';

interface LoginProps {
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}

export default function Login({
    status,
    canResetPassword,
    canRegister,
}: LoginProps) {
    return (
        <>
            <Head title="Se connecter - ALCHIFUNDA" />

            {/* Header fixe pour la navigation */}
            <header className="fixed top-0 w-full bg-white/95 shadow-sm backdrop-blur-sm z-50 py-4 px-6">
                <div className="container mx-auto flex justify-between items-center">
                    <a href='/' className="flex items-center gap-2.5 text-2xl font-bold text-[#4A3AFF]">
                        <i className="fas fa-atom text-[#00C9B7] text-3xl"></i>
                        <span>ALCHIFUNDA</span>
                    </a>
                </div>
            </header>

            {/* Contenu principal de la page de connexion */}
            <div className="min-h-screen bg-gradient-to-br from-[#f5f7ff] to-[#eef2ff] flex items-center justify-center p-[70px_20px_40px] relative overflow-hidden">
                {/* Effets décoratifs */}
                <div className="absolute w-[300px] h-[300px] rounded-full bg-[#4A3AFF]/5 top-[-150px] right-[-150px]"></div>
                <div className="absolute w-[200px] h-[200px] rounded-full bg-[#00C9B7]/5 bottom-[-100px] left-[-100px]"></div>

                {/* Carte de connexion */}
                <div className="bg-white rounded-2xl p-12 shadow-xl w-full max-w-[480px] relative z-10 border border-black/5">
                    <div className="text-center mb-10">
                        <div className="flex items-center justify-center gap-3 font-bold text-3xl text-[#4A3AFF] mb-5">
                            <i className="fas fa-atom text-[#00C9B7] text-4xl"></i>
                            ALCHIFUNDA
                        </div>
                        <h1 className="text-3xl font-semibold text-[#1A1A2E] font-serif mb-2.5">Se connecter</h1>
                        <p className="text-gray-500">
                            Entrez vos identifiants pour accéder à votre compte
                        </p>
                    </div>

                    {status && (
                        <div className="mb-4 text-center text-sm font-medium text-green-600">
                            {status}
                        </div>
                    )}

                    <Form
                        {...store.form()}
                        resetOnSuccess={['password']}
                        disableWhileProcessing
                    >
                        {({ processing, errors }) => (
                            <>
                                {/* Champ Email */}
                                <div className="mb-6">
                                    <Label htmlFor="email" className='text-black'>Adresse email</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        name="email"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        autoComplete="email"
                                        placeholder="email@example.com"
                                    />
                                    <InputError message={errors.email} className="mt-2" />
                                </div>

                                {/* Champ Mot de passe */}
                                <div className="mb-6">
                                    <div className="flex items-center justify-between">
                                        <Label htmlFor="password" className='text-black'>Mot de passe</Label>
                                        {canResetPassword && (
                                            <a
                                                href={request()}
                                                tabIndex={4}
                                                className="text-sm text-[#4A3AFF] font-semibold transition-all hover:text-[#3a2ae0] hover:underline"
                                            >
                                                Mot de passe oublié ?
                                            </a>
                                        )}
                                    </div>
                                    <Input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        tabIndex={2}
                                        autoComplete="current-password"
                                        placeholder="Mot de passe"
                                    />
                                    <InputError message={errors.password} className="mt-2" />
                                </div>

                                {/* Case "Se souvenir de moi" */}
                                <div className="flex items-center space-x-3 mb-6">
                                    <Checkbox
                                        id="remember"
                                        name="remember"
                                        tabIndex={3}
                                    />
                                    <Label htmlFor="remember" className='text-black'>Se souvenir de moi</Label>
                                </div>

                                {/* Bouton de soumission */}
                                <Button
                                    type="submit"
                                    className="mt-2 w-full bg-blue-400"
                                    tabIndex={4}
                                    disabled={processing}
                                    data-test="login-button"
                                >
                                    {processing && <Spinner />}
                                    Se connecter
                                </Button>
                            </>
                        )}
                    </Form>

                    {/* Lien vers la page d'inscription */}
                    {canRegister && (
                        <div className="text-center mt-7.5 text-gray-500 text-sm">
                            Vous n'avez pas de compte ?{' '}
                            <a
                                href='/register'
                                tabIndex={5}
                                className="text-[#4A3AFF] font-semibold transition-all hover:text-[#3a2ae0] hover:underline"
                            >
                                S'inscrire
                            </a>
                        </div>
                    )}
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

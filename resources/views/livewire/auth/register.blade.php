<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="h-screen w-screen overflow-hidden bg-neutral-950 text-white">

    <div class="flex flex-col justify-center items-center h-full w-full p-8">
        <div class="w-full max-w-md">
            <h1 class="text-4xl font-bold text-center mb-6">Crear una cuenta</h1>
            <p class="text-center text-gray-400 mb-8 text-sm">Ingrese sus datos para registrarse</p>

            <form wire:submit="register" class="flex flex-col gap-6">
                <!-- Nombre completo -->
                <div>
                    <label class="block text-sm mb-1">Nombre completo</label>
                    <input 
                        type="text" 
                        wire:model="name" 
                        required 
                        autofocus 
                        placeholder="Nombre completo"
                        class="w-full rounded-md p-3 border border-gray-600 bg-gray-800 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                </div>

                <!-- Correo electrónico -->
                <div>
                    <label class="block text-sm mb-1">Correo electrónico</label>
                    <input 
                        type="email" 
                        wire:model="email" 
                        required 
                        placeholder="correo@ejemplo.com"
                        class="w-full rounded-md p-3 border border-gray-600 bg-gray-800 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                </div>

                <!-- Contraseña -->
                <div>
                    <label class="block text-sm mb-1">Contraseña</label>
                    <input 
                        type="password" 
                        wire:model="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="Ingrese su contraseña"
                        class="w-full rounded-md p-3 border border-gray-600 bg-gray-800 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                </div>

                <!-- Confirmar contraseña -->
                <div>
                    <label class="block text-sm mb-1">Confirmar contraseña</label>
                    <input 
                        type="password" 
                        wire:model="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Confirme su contraseña"
                        class="w-full rounded-md p-3 border border-gray-600 bg-gray-800 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                </div>

                <!-- Botón de crear cuenta -->
                <button 
                    type="submit" 
                    class="bg-indigo-600 hover:bg-indigo-700 rounded-md p-3 font-semibold text-white w-full transition"
                >
                    Crear cuenta
                </button>
            </form>

            <div class="text-center text-xs text-gray-400 mt-6">
                ¿Ya tiene una cuenta?
                <a href="{{ route('login') }}" class="hover:underline text-indigo-400">Iniciar sesión</a>
            </div>
        </div>
    </div>

    @fluxScripts
</body>
</html>

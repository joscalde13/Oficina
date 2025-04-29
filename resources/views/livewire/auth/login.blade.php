<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('Correo o contraseña incorrectos.'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('Demasiados intentos. Intente nuevamente en :seconds segundos.', ['seconds' => $seconds]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
};
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="h-screen w-screen overflow-hidden bg-neutral-950 text-white">

    <!-- Ahora todo el fondo es un solo lado -->
    <div class="flex flex-col justify-center items-center h-full w-full p-8">

        <div class="w-full max-w-md">
            <h1 class="text-4xl font-bold text-center mb-6">Bienvenido de nuevo</h1>
            <p class="text-center text-gray-400 mb-8 text-sm">Por favor ingrese sus credenciales</p>

            <form wire:submit="login" class="flex flex-col gap-6">
                <!-- Email -->
                <div>
                    <label class="block text-sm mb-1">Correo electrónico</label>
                    <input 
                        type="email" 
                        wire:model="email" 
                        required 
                        autofocus 
                        placeholder="usuario@oficina.com"
                        class="w-full rounded-md p-3 border border-gray-600 bg-gray-800 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm mb-1">Contraseña</label>
                    <input 
                        type="password" 
                        wire:model="password" 
                        required 
                        placeholder="Ingrese su contraseña"
                        class="w-full rounded-md p-3 border border-gray-600 bg-gray-800 text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    >
                </div>

             

                <!-- Botón -->
                <button 
                    type="submit" 
                    class="bg-indigo-600 hover:bg-indigo-700 rounded-md p-3 font-semibold text-white w-full transition"
                >
                    Ingresar
                </button>
            </form>

          

            <div class="text-center text-xs mt-2">
                <span class="text-gray-400">¿No tiene cuenta?</span> 
                <a href="{{ route('register') }}" class="hover:underline text-gray-400">Regístrese</a>
            </div>
        </div>

    </div>

    @fluxScripts
</body>
</html>

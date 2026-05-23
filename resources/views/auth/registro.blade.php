<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear cuenta · VOLT</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            letter-spacing: -0.01em;
            height: 100%;
        }
        .font-bebas {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.03em;
        }
    </style>
</head>
<body class="h-full bg-white antialiased overflow-hidden">

    <div class="h-screen flex">

        {{-- ============================= --}}
        {{-- IZQUIERDA: foto motivacional --}}
        {{-- ============================= --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-neutral-900 overflow-hidden">
            <img src="{{ asset('img/auth-fondo.jpg') }}"
                 alt="Atleta entrenando"
                 class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0"
                 style="background: linear-gradient(180deg, rgba(8,13,28,0.45) 0%, rgba(8,13,28,0.75) 60%, rgba(8,13,28,0.95) 100%);"></div>

            <div class="relative z-10 flex flex-col justify-between p-12 w-full text-white">
                <div></div>

                <div>
                    <div class="w-16 h-1 bg-[#ffd600] mb-6"></div>
                    <h1 class="font-bebas text-7xl leading-none mb-2">EMPIEZA.</h1>
                    <h1 class="font-bebas text-7xl leading-none mb-2">ENTRENA.</h1>
                    <h1 class="font-bebas text-7xl leading-none mb-6 text-[#ffd600]">EVOLUCIONA.</h1>
                    <p class="text-lg text-neutral-200 max-w-md leading-relaxed">
                        Únete a VOLT y empieza a registrar tu progreso desde hoy mismo.
                    </p>
                </div>
            </div>
        </div>

        {{-- ============================= --}}
        {{-- DERECHA: formulario --}}
        {{-- ============================= --}}
        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center px-6 sm:px-12 bg-white overflow-hidden py-4">

            <div class="w-full max-w-md">

                <div class="flex justify-center mb-1">
                    <img src="{{ asset('img/volt-logo.svg') }}"
                         alt="VOLT"
                         style="height: 90px; width: auto;">
                </div>

                <div class="text-center mb-4">
                    <h2 class="font-bebas text-3xl text-[#0f172a] mb-1">ÚNETE A VOLT</h2>
                    <p class="text-neutral-500 text-sm">Crea tu cuenta y empieza a entrenar</p>
                </div>

                @if ($errors->has('general'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                        {{ $errors->first('general') }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/registro') }}" class="space-y-3">
                    @csrf

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-neutral-700 mb-2">
                            Nombre
                        </label>
                        <input type="text"
                               id="nombre"
                               name="nombre"
                               value="{{ old('nombre') }}"
                               required
                               autofocus
                               placeholder="Tu nombre"
                               class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-[#ffd600] focus:border-[#ffd600] outline-none transition">
                        @error('nombre')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-neutral-700 mb-2">
                            Correo electrónico
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="tucorreo@ejemplo.com"
                               class="w-full px-4 py-3 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-[#ffd600] focus:border-[#ffd600] outline-none transition">
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contraseña con ojo --}}
                    <div>
                        <label for="contrasena" class="block text-sm font-semibold text-neutral-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="contrasena"
                                   name="contrasena"
                                   required
                                   placeholder="Mínimo 6 caracteres"
                                   class="w-full px-4 py-3 pr-12 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-[#ffd600] focus:border-[#ffd600] outline-none transition">
                            <button type="button"
                                    onclick="togglePassword('contrasena', this)"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-neutral-400 hover:text-neutral-700 transition"
                                    tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 eye-closed hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('contrasena')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña con ojo --}}
                    <div>
                        <label for="contrasena_confirmation" class="block text-sm font-semibold text-neutral-700 mb-2">
                            Confirmar contraseña
                        </label>
                        <div class="relative">
                            <input type="password"
                                   id="contrasena_confirmation"
                                   name="contrasena_confirmation"
                                   required
                                   placeholder="Repite la contraseña"
                                   class="w-full px-4 py-3 pr-12 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-[#ffd600] focus:border-[#ffd600] outline-none transition">
                            <button type="button"
                                    onclick="togglePassword('contrasena_confirmation', this)"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-neutral-400 hover:text-neutral-700 transition"
                                    tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 eye-closed hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-[#ffd600] hover:bg-[#e6c000] text-[#0f172a] font-bold py-3 rounded-lg transition shadow-sm hover:shadow-md tracking-wide mt-2">
                        CREAR CUENTA
                    </button>

                    <p class="text-center text-sm text-neutral-600 pt-2">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" class="font-semibold text-[#0f172a] hover:text-[#ffd600] transition">
                            Inicia sesión
                        </a>
                    </p>
                </form>

                <p class="text-center text-xs text-neutral-400 mt-4">
                    VOLT · GymTracker — Proyecto Final DAW 2025/2026
                </p>

            </div>

        </div>

    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>

</body>
</html>

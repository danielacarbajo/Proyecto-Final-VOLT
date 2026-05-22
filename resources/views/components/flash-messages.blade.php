{{--
    Componente de mensajes flash para VOLT.
    Muestra toasts flotantes arriba a la derecha cuando hay session('exito'),
    session('error'), session('aviso') o errores de validación.
    Se cierran solos a los 4 segundos o pulsando la X.
--}}

@if (session('exito') || session('error') || session('aviso') || $errors->any())
    <div id="flash-container" class="fixed top-4 right-4 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none">

        {{-- Mensaje de éxito --}}
        @if (session('exito'))
            <div class="flash-toast pointer-events-auto bg-green-50 border-l-4 border-green-500 text-green-900 px-4 py-3 rounded-lg shadow-lg flex items-start gap-3"
                 role="alert">
                <span class="text-xl leading-none">✅</span>
                <div class="flex-1 text-sm font-medium">{{ session('exito') }}</div>
                <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 transition text-lg leading-none">×</button>
            </div>
        @endif

        {{-- Mensaje de error --}}
        @if (session('error'))
            <div class="flash-toast pointer-events-auto bg-red-50 border-l-4 border-red-500 text-red-900 px-4 py-3 rounded-lg shadow-lg flex items-start gap-3"
                 role="alert">
                <span class="text-xl leading-none">⛔</span>
                <div class="flex-1 text-sm font-medium">{{ session('error') }}</div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 transition text-lg leading-none">×</button>
            </div>
        @endif

        {{-- Mensaje de aviso/advertencia --}}
        @if (session('aviso'))
            <div class="flash-toast pointer-events-auto bg-amber-50 border-l-4 border-amber-500 text-amber-900 px-4 py-3 rounded-lg shadow-lg flex items-start gap-3"
                 role="alert">
                <span class="text-xl leading-none">⚠️</span>
                <div class="flex-1 text-sm font-medium">{{ session('aviso') }}</div>
                <button type="button" onclick="this.parentElement.remove()" class="text-amber-700 hover:text-amber-900 transition text-lg leading-none">×</button>
            </div>
        @endif

        {{-- Errores de validación (lista con todos) --}}
        @if ($errors->any())
            <div class="flash-toast flash-toast-validacion pointer-events-auto bg-red-50 border-l-4 border-red-500 text-red-900 px-4 py-3 rounded-lg shadow-lg flex items-start gap-3"
                 role="alert">
                <span class="text-xl leading-none">📝</span>
                <div class="flex-1 text-sm">
                    <div class="font-semibold mb-1">Revisa el formulario:</div>
                    <ul class="list-disc list-inside space-y-0.5 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 transition text-lg leading-none">×</button>
            </div>
        @endif

    </div>

    <style>
        .flash-toast {
            animation: flash-slide-in 0.3s ease-out;
        }

        @keyframes flash-slide-in {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .flash-toast.flash-fade-out {
            animation: flash-slide-out 0.4s ease-in forwards;
        }

        @keyframes flash-slide-out {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(20px);
            }
        }
    </style>

    <script>
        // Cierra todos los toasts (excepto el de validación) a los 4 segundos.
        document.addEventListener('DOMContentLoaded', function () {
            const toasts = document.querySelectorAll('.flash-toast:not(.flash-toast-validacion)');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.classList.add('flash-fade-out');
                    setTimeout(() => toast.remove(), 400);
                }, 4000);
            });
        });
    </script>
@endif

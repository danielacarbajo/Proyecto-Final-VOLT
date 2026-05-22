<?php

namespace Database\Seeders;

use App\Helpers\EjercicioHelper;
use App\Models\DetalleEntrenamiento;
use App\Models\Ejercicio;
use App\Models\Entrenamiento;
use App\Models\Rutina;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsuariosPruebaSeeder extends Seeder
{
    /**
     * Crea 6 usuarios de prueba con perfiles realistas:
     * - Distintos niveles (principiante, intermedio, avanzado)
     * - Cada uno con sus rutinas y ejercicios
     * - Entrenamientos distribuidos en los últimos 6 meses
     * - Pesos progresivos para que las gráficas muestren evolución
     */
    public function run(): void
    {
        // ============================================
        // PERFILES DE USUARIO
        // ============================================
        $perfiles = [
            [
                'nombre' => 'Carlos Ruiz',
                'email' => 'carlos@volt.com',
                'nivel' => 'avanzado',
                'rutinas' => ['Pecho y tríceps', 'Espalda y bíceps', 'Pierna completa'],
                'frecuencia' => 4, // entrenos por semana
            ],
            [
                'nombre' => 'María López',
                'email' => 'maria@volt.com',
                'nivel' => 'intermedio',
                'rutinas' => ['Full Body A', 'Full Body B'],
                'frecuencia' => 3,
            ],
            [
                'nombre' => 'Pablo García',
                'email' => 'pablo@volt.com',
                'nivel' => 'avanzado',
                'rutinas' => ['Push', 'Pull', 'Pierna'],
                'frecuencia' => 5,
            ],
            [
                'nombre' => 'Lucía Fernández',
                'email' => 'lucia@volt.com',
                'nivel' => 'principiante',
                'rutinas' => ['Iniciación al gimnasio', 'Cardio y core'],
                'frecuencia' => 2,
            ],
            [
                'nombre' => 'Javier Martín',
                'email' => 'javier@volt.com',
                'nivel' => 'intermedio',
                'rutinas' => ['Tren superior', 'Tren inferior'],
                'frecuencia' => 3,
            ],
            [
                'nombre' => 'Sofía Torres',
                'email' => 'sofia@volt.com',
                'nivel' => 'avanzado',
                'rutinas' => ['Glúteo y pierna', 'Espalda y hombro', 'HIIT y core'],
                'frecuencia' => 4,
            ],
        ];

        // ============================================
        // EJERCICIOS POR RUTINA SEGÚN EL NOMBRE
        // ============================================
        $ejerciciosPorRutina = [
            'Pecho y tríceps' => ['Press de banca', 'Press inclinado con mancuernas', 'Aperturas con mancuernas', 'Press francés', 'Fondos en banco'],
            'Espalda y bíceps' => ['Dominadas', 'Remo con barra', 'Jalón al pecho', 'Curl con barra', 'Curl martillo'],
            'Pierna completa' => ['Sentadilla', 'Prensa de piernas', 'Extensión de cuádriceps', 'Curl femoral', 'Zancadas'],
            'Full Body A' => ['Sentadilla', 'Press de banca', 'Remo con barra', 'Press militar', 'Plancha'],
            'Full Body B' => ['Peso muerto', 'Press inclinado con mancuernas', 'Jalón al pecho', 'Elevaciones laterales', 'Crunch abdominal'],
            'Push' => ['Press de banca', 'Press militar', 'Press inclinado con mancuernas', 'Elevaciones laterales', 'Press francés'],
            'Pull' => ['Dominadas', 'Remo con barra', 'Jalón al pecho', 'Curl con barra', 'Curl martillo'],
            'Pierna' => ['Sentadilla', 'Peso muerto', 'Prensa de piernas', 'Curl femoral', 'Extensión de cuádriceps'],
            'Iniciación al gimnasio' => ['Sentadilla', 'Press de banca', 'Jalón al pecho', 'Plancha'],
            'Cardio y core' => ['Cinta de correr', 'Bicicleta estática', 'Plancha', 'Crunch abdominal', 'Russian twists'],
            'Tren superior' => ['Press de banca', 'Dominadas', 'Press militar', 'Curl con barra', 'Press francés'],
            'Tren inferior' => ['Sentadilla', 'Peso muerto', 'Zancadas', 'Curl femoral', 'Hip thrust'],
            'Glúteo y pierna' => ['Hip thrust', 'Sentadilla búlgara', 'Puente de glúteos', 'Patada de glúteo', 'Sentadilla'],
            'Espalda y hombro' => ['Dominadas', 'Remo con barra', 'Press militar', 'Elevaciones laterales', 'Pájaros'],
            'HIIT y core' => ['Cinta de correr', 'Elíptica', 'Plancha', 'Elevaciones de pierna', 'Russian twists'],
        ];

        // ============================================
        // PESOS BASE POR EJERCICIO Y NIVEL (en kg)
        // ============================================
        $pesosBase = [
            'principiante' => [
                'Press de banca' => 30, 'Press inclinado con mancuernas' => 12, 'Aperturas con mancuernas' => 6, 'Fondos en paralelas' => 0, 'Fondos en banco' => 0,
                'Dominadas' => 0, 'Remo con barra' => 25, 'Jalón al pecho' => 30, 'Peso muerto' => 40,
                'Sentadilla' => 30, 'Prensa de piernas' => 50, 'Zancadas' => 8, 'Extensión de cuádriceps' => 20, 'Curl femoral' => 15,
                'Press militar' => 20, 'Elevaciones laterales' => 4, 'Pájaros' => 4, 'Encogimientos' => 12,
                'Curl con barra' => 15, 'Curl martillo' => 6, 'Press francés' => 12,
                'Plancha' => 0, 'Crunch abdominal' => 0, 'Elevaciones de pierna' => 0, 'Russian twists' => 4,
                'Hip thrust' => 30, 'Patada de glúteo' => 5, 'Sentadilla búlgara' => 8, 'Puente de glúteos' => 0,
                'Cinta de correr' => 0, 'Bicicleta estática' => 0, 'Elíptica' => 0, 'Remo en máquina' => 0,
            ],
            'intermedio' => [
                'Press de banca' => 60, 'Press inclinado con mancuernas' => 20, 'Aperturas con mancuernas' => 10, 'Fondos en paralelas' => 0, 'Fondos en banco' => 5,
                'Dominadas' => 0, 'Remo con barra' => 50, 'Jalón al pecho' => 55, 'Peso muerto' => 80,
                'Sentadilla' => 70, 'Prensa de piernas' => 100, 'Zancadas' => 14, 'Extensión de cuádriceps' => 40, 'Curl femoral' => 30,
                'Press militar' => 40, 'Elevaciones laterales' => 8, 'Pájaros' => 8, 'Encogimientos' => 30,
                'Curl con barra' => 30, 'Curl martillo' => 12, 'Press francés' => 25,
                'Plancha' => 0, 'Crunch abdominal' => 5, 'Elevaciones de pierna' => 0, 'Russian twists' => 8,
                'Hip thrust' => 60, 'Patada de glúteo' => 10, 'Sentadilla búlgara' => 16, 'Puente de glúteos' => 20,
                'Cinta de correr' => 0, 'Bicicleta estática' => 0, 'Elíptica' => 0, 'Remo en máquina' => 0,
            ],
            'avanzado' => [
                'Press de banca' => 90, 'Press inclinado con mancuernas' => 30, 'Aperturas con mancuernas' => 16, 'Fondos en paralelas' => 20, 'Fondos en banco' => 15,
                'Dominadas' => 10, 'Remo con barra' => 80, 'Jalón al pecho' => 80, 'Peso muerto' => 120,
                'Sentadilla' => 100, 'Prensa de piernas' => 160, 'Zancadas' => 24, 'Extensión de cuádriceps' => 60, 'Curl femoral' => 50,
                'Press militar' => 60, 'Elevaciones laterales' => 12, 'Pájaros' => 12, 'Encogimientos' => 50,
                'Curl con barra' => 45, 'Curl martillo' => 18, 'Press francés' => 35,
                'Plancha' => 0, 'Crunch abdominal' => 10, 'Elevaciones de pierna' => 0, 'Russian twists' => 12,
                'Hip thrust' => 100, 'Patada de glúteo' => 15, 'Sentadilla búlgara' => 24, 'Puente de glúteos' => 30,
                'Cinta de correr' => 0, 'Bicicleta estática' => 0, 'Elíptica' => 0, 'Remo en máquina' => 0,
            ],
        ];

        // ============================================
        // CREAR USUARIOS, RUTINAS, EJERCICIOS Y ENTRENAMIENTOS
        // ============================================
        foreach ($perfiles as $perfil) {

            // Crear usuario.
            $usuario = Usuario::updateOrCreate(
                ['email' => $perfil['email']],
                [
                    'rol_id' => 1,
                    'nombre' => $perfil['nombre'],
                    'contrasena' => 'password',
                    'activo' => true,
                    'fecha_creacion' => Carbon::now()->subMonths(rand(2, 5))->startOfMonth()->addDays(rand(0, 15)),
                ]
            );

            $this->command->info("✅ Usuario creado: {$perfil['nombre']} ({$perfil['email']})");

            // Recolectar todos los ejercicios únicos que usa este usuario.
            $ejerciciosUnicosNombres = [];
            foreach ($perfil['rutinas'] as $nombreRutina) {
                foreach ($ejerciciosPorRutina[$nombreRutina] as $nomEj) {
                    if (!in_array($nomEj, $ejerciciosUnicosNombres)) {
                        $ejerciciosUnicosNombres[] = $nomEj;
                    }
                }
            }

            // Crear los ejercicios del usuario.
            $ejerciciosUsuario = [];
            foreach ($ejerciciosUnicosNombres as $nomEj) {
                $ej = Ejercicio::create([
                    'usuario_id' => $usuario->id,
                    'nombre' => $nomEj,
                    'grupo_muscular' => EjercicioHelper::grupoDeEjercicio($nomEj),
                ]);
                $ejerciciosUsuario[$nomEj] = $ej;
            }

            // Crear las rutinas del usuario.
            $rutinasUsuario = [];
            foreach ($perfil['rutinas'] as $nombreRutina) {
                $rutina = Rutina::create([
                    'usuario_id' => $usuario->id,
                    'nombre' => $nombreRutina,
                    'descripcion' => 'Rutina de ' . strtolower($nombreRutina) . ' para entrenamiento ' . $perfil['nivel'] . '.',
                ]);
                $rutinasUsuario[] = $rutina;
            }

            // ============================================
            // CREAR ENTRENAMIENTOS EN LOS ÚLTIMOS 6 MESES
            // ============================================
            $hoy = Carbon::today();
            $inicio = $hoy->copy()->subMonths(6);
            $diasTotales = $inicio->diffInDays($hoy);
            $diasEntreSesiones = (int) floor(7 / $perfil['frecuencia']);

            $fechaActual = $inicio->copy();
            $contadorEntreno = 0;

            while ($fechaActual->lte($hoy)) {

                // Elegir una rutina aleatoria.
                $rutinaElegida = $rutinasUsuario[array_rand($rutinasUsuario)];
                $ejerciciosRutina = $ejerciciosPorRutina[$rutinaElegida->nombre];

                // Crear entrenamiento.
                $entrenamiento = Entrenamiento::create([
                    'usuario_id' => $usuario->id,
                    'rutina_id' => $rutinaElegida->id,
                    'fecha_entrenamiento' => $fechaActual->copy(),
                ]);

                // Calcular progreso (cuanto más entreno, más peso → simulación realista).
                $progreso = 1 + ($contadorEntreno / 100); // +1% por entrenamiento.

                // Crear detalles para cada ejercicio de la rutina.
                foreach ($ejerciciosRutina as $nomEj) {
                    $pesoBase = $pesosBase[$perfil['nivel']][$nomEj] ?? 0;
                    $pesoFinal = $pesoBase > 0 ? round($pesoBase * $progreso + rand(-2, 2), 1) : 0;
                    $pesoFinal = max(0, $pesoFinal);

                    DetalleEntrenamiento::create([
                        'entrenamiento_id' => $entrenamiento->id,
                        'ejercicio_id' => $ejerciciosUsuario[$nomEj]->id,
                        'series' => rand(3, 4),
                        'repeticiones' => rand(8, 12),
                        'peso' => $pesoFinal,
                    ]);
                }

                $contadorEntreno++;
                $fechaActual->addDays($diasEntreSesiones + rand(0, 1));
            }

            $this->command->info("   📅 {$contadorEntreno} entrenamientos creados para {$perfil['nombre']}.");
        }

        $this->command->info('');
        $this->command->info('🎉 Datos de prueba creados correctamente.');
        $this->command->info('🔑 Contraseña para todos los usuarios de prueba: password');
    }
}

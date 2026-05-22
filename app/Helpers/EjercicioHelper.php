<?php

namespace App\Helpers;

class EjercicioHelper
{
    /**
     * Catálogo predefinido de ejercicios disponibles en la aplicación.
     * Cada entrada tiene: nombre, grupo_muscular y la imagen que se usará.
     *
     * Si quieres añadir un ejercicio nuevo, simplemente añade una línea aquí
     * y asegúrate de que su grupo_muscular esté en la lista GRUPOS.
     */
    public const CATALOGO = [
        // PECHO
        'Press de banca' => 'Pecho',
        'Press inclinado con mancuernas' => 'Pecho',
        'Aperturas con mancuernas' => 'Pecho',
        'Fondos en paralelas' => 'Pecho',

        // ESPALDA
        'Dominadas' => 'Espalda',
        'Remo con barra' => 'Espalda',
        'Jalón al pecho' => 'Espalda',
        'Peso muerto' => 'Espalda',

        // PIERNA
        'Sentadilla' => 'Pierna',
        'Prensa de piernas' => 'Pierna',
        'Zancadas' => 'Pierna',
        'Extensión de cuádriceps' => 'Pierna',
        'Curl femoral' => 'Pierna',

        // HOMBROS
        'Press militar' => 'Hombros',
        'Elevaciones laterales' => 'Hombros',
        'Pájaros' => 'Hombros',
        'Encogimientos' => 'Hombros',

        // BRAZOS
        'Curl con barra' => 'Brazos',
        'Curl martillo' => 'Brazos',
        'Press francés' => 'Brazos',
        'Fondos en banco' => 'Brazos',

        // ABDOMINALES
        'Plancha' => 'Abdominales',
        'Crunch abdominal' => 'Abdominales',
        'Elevaciones de pierna' => 'Abdominales',
        'Russian twists' => 'Abdominales',

        // GLÚTEOS
        'Hip thrust' => 'Glúteos',
        'Patada de glúteo' => 'Glúteos',
        'Sentadilla búlgara' => 'Glúteos',
        'Puente de glúteos' => 'Glúteos',

        // CARDIO
        'Cinta de correr' => 'Cardio',
        'Bicicleta estática' => 'Cardio',
        'Elíptica' => 'Cardio',
        'Remo en máquina' => 'Cardio',
    ];

    /**
     * Lista de grupos musculares disponibles.
     */
    public const GRUPOS = [
        'Pecho',
        'Espalda',
        'Pierna',
        'Hombros',
        'Brazos',
        'Abdominales',
        'Glúteos',
        'Cardio',
    ];

    /**
     * Devuelve los nombres de los ejercicios del catálogo agrupados por grupo muscular.
     * Útil para construir el dropdown agrupado con <optgroup>.
     */
    public static function ejerciciosAgrupados(): array
    {
        $resultado = [];

        foreach (self::GRUPOS as $grupo) {
            $resultado[$grupo] = [];
        }

        foreach (self::CATALOGO as $nombre => $grupo) {
            $resultado[$grupo][] = $nombre;
        }

        return $resultado;
    }

    /**
     * Devuelve el grupo muscular asociado a un ejercicio del catálogo.
     * Si no está en el catálogo (ejercicio personalizado), devuelve null.
     */
    public static function grupoDeEjercicio(string $nombre): ?string
    {
        return self::CATALOGO[$nombre] ?? null;
    }

    /**
     * Devuelve la ruta de la imagen asociada a un grupo muscular.
     * Si el grupo no existe, devuelve la imagen genérica.
     */
    public static function imagen(?string $grupo): string
    {
        if (empty($grupo)) {
            return asset('img/ejercicios/generico.jpg');
        }

        $mapa = [
            'Pecho' => 'pecho.jpg',
            'Espalda' => 'espalda.jpg',
            'Pierna' => 'pierna.jpg',
            'Hombros' => 'hombros.jpg',
            'Brazos' => 'brazos.jpg',
            'Abdominales' => 'abdominales.jpg',
            'Glúteos' => 'gluteos.jpg',
            'Cardio' => 'cardio.jpg',
        ];

        $archivo = $mapa[$grupo] ?? 'generico.jpg';

        return asset('img/ejercicios/' . $archivo);
    }
}

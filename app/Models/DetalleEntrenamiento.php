<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleEntrenamiento extends Model
{
    use HasFactory;

    /**
     * Nombre real de la tabla.
     */
    protected $table = 'detalle_entrenamiento';

    protected $fillable = [
        'entrenamiento_id',
        'ejercicio_id',
        'series',
        'repeticiones',
        'peso',
    ];

    /**
     * Conversión del peso a decimal con 2 decimales.
     */
    protected function casts(): array
    {
        return [
            'peso' => 'decimal:2',
        ];
    }

    /**
     * Cada detalle pertenece a un entrenamiento.
     */
    public function entrenamiento(): BelongsTo
    {
        return $this->belongsTo(Entrenamiento::class, 'entrenamiento_id');
    }

    /**
     * Cada detalle hace referencia a un ejercicio.
     */
    public function ejercicio(): BelongsTo
    {
        return $this->belongsTo(Ejercicio::class, 'ejercicio_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleRutina extends Model
{
    use HasFactory;

    /**
     * Nombre real de la tabla. Lo especificamos porque Laravel buscaría
     * 'detalle_rutinas' (en plural) y nuestra tabla es 'detalle_rutina'.
     */
    protected $table = 'detalle_rutina';

    protected $fillable = [
        'rutina_id',
        'ejercicio_id',
        'series_por_defecto',
        'repeticiones_por_defecto',
        'posicion',
    ];

    /**
     * Cada detalle pertenece a una rutina.
     */
    public function rutina(): BelongsTo
    {
        return $this->belongsTo(Rutina::class, 'rutina_id');
    }

    /**
     * Cada detalle hace referencia a un ejercicio.
     */
    public function ejercicio(): BelongsTo
    {
        return $this->belongsTo(Ejercicio::class, 'ejercicio_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ejercicio extends Model
{
    use HasFactory;

    protected $table = 'ejercicios';

    protected $fillable = [
        'usuario_id',
        'nombre',
        'grupo_muscular',
    ];

    /**
     * Cada ejercicio pertenece a un usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Un ejercicio puede aparecer en muchas rutinas (via detalle_rutina).
     */
    public function rutinas(): BelongsToMany
    {
        return $this->belongsToMany(Rutina::class, 'detalle_rutina')
            ->withPivot('series_por_defecto', 'repeticiones_por_defecto', 'posicion')
            ->withTimestamps();
    }

    /**
     * Un ejercicio puede aparecer en muchos detalles de entrenamiento.
     */
    public function detallesEntrenamiento(): HasMany
    {
        return $this->hasMany(DetalleEntrenamiento::class, 'ejercicio_id');
    }
}

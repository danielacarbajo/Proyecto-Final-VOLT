<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rutina extends Model
{
    use HasFactory;

    protected $table = 'rutinas';

    protected $fillable = [
        'usuario_id',
        'nombre',
        'descripcion',
    ];

    /**
     * Cada rutina pertenece a un usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Una rutina tiene muchos detalles (ejercicios con sus series/reps por defecto).
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleRutina::class, 'rutina_id');
    }

    /**
     * Una rutina puede tener muchos entrenamientos asociados.
     */
    public function entrenamientos(): HasMany
    {
        return $this->hasMany(Entrenamiento::class, 'rutina_id');
    }

    /**
     * Acceso directo a los ejercicios de la rutina (relación muchos a muchos
     * a través de detalle_rutina).
     */
    public function ejercicios(): BelongsToMany
    {
        return $this->belongsToMany(Ejercicio::class, 'detalle_rutina')
            ->withPivot('series_por_defecto', 'repeticiones_por_defecto', 'posicion')
            ->withTimestamps();
    }
}

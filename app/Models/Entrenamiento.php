<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entrenamiento extends Model
{
    use HasFactory;

    protected $table = 'entrenamientos';

    protected $fillable = [
        'usuario_id',
        'rutina_id',
        'fecha_entrenamiento',
    ];

    /**
     * Convierte fecha_entrenamiento a tipo Date automáticamente.
     */
    protected function casts(): array
    {
        return [
            'fecha_entrenamiento' => 'date',
        ];
    }

    /**
     * Cada entrenamiento pertenece a un usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Un entrenamiento puede estar asociado a una rutina (o no).
     */
    public function rutina(): BelongsTo
    {
        return $this->belongsTo(Rutina::class, 'rutina_id');
    }

    /**
     * Un entrenamiento tiene muchos detalles (ejercicios realizados).
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleEntrenamiento::class, 'entrenamiento_id');
    }
}

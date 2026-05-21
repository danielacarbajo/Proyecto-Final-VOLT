<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    use HasFactory;

    /**
     * Nombre real de la tabla en la base de datos.
     * Lo especificamos porque el plural de "Rol" en español no coincide con la convención de Laravel.
     */
    protected $table = 'roles';

    /**
     * Campos que se pueden asignar masivamente desde formularios.
     */
    protected $fillable = ['nombre'];

    /**
     * Relación: un rol puede tener muchos usuarios asignados.
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'rol_id');
    }
}

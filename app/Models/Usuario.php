<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nombre real de la tabla en la base de datos.
     */
    protected $table = 'usuarios';

    /**
     * Campos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'rol_id',
        'nombre',
        'email',
        'contrasena',
        'fecha_creacion',
    ];

    /**
     * Campos que se ocultan al convertir el modelo a array/JSON.
     * La contraseña nunca debe exponerse, ni siquiera por error.
     */
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    /**
     * Conversiones automáticas de tipos al leer/guardar.
     */
    protected function casts(): array
    {
        return [
            'fecha_creacion' => 'date',
            'contrasena' => 'hashed',
        ];
    }

    /**
     * Le decimos a Laravel que nuestra columna de contraseña se llama 'contrasena'
     * (en lugar del 'password' por defecto).
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Relación: cada usuario pertenece a un rol.
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    /**
     * Relación: un usuario tiene muchas rutinas.
     */
    public function rutinas(): HasMany
    {
        return $this->hasMany(Rutina::class, 'usuario_id');
    }

    /**
     * Relación: un usuario tiene muchos ejercicios.
     */
    public function ejercicios(): HasMany
    {
        return $this->hasMany(Ejercicio::class, 'usuario_id');
    }

    /**
     * Relación: un usuario tiene muchos entrenamientos.
     */
    public function entrenamientos(): HasMany
    {
        return $this->hasMany(Entrenamiento::class, 'usuario_id');
    }

    /**
     * Helper para saber si un usuario es administrador.
     */
    public function esAdministrador(): bool
    {
        return $this->rol_id === 2;
    }
}

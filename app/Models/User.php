<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Usuarios del sitio (lectores y administradores).
 *
 * El campo "role" ('cliente' | 'admin') determina quién puede
 * acceder al panel /admin (lo verifica EnsureUserIsAdmin).
 *
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Campos que se permiten al crear/actualizar masivamente.
     * "role" se incluye para poder dar de alta administradores
     * desde el seeder.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'password', 'role'];

    /**
     * Atributos que nunca se devuelven al exterior (JSON/sesión):
     * la contraseña hasheada y el token de "recordar".
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Relación: un usuario escribe muchas entradas del blog (1:N).
     * user_id en posts es anulable (nullOnDelete): si borramos al
     * usuario, la entrada queda sin autor en lugar de borrarse.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Post, \App\Models\User>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    /**
     * Relación: un usuario deja muchas reseñas, una por libro (1:N
     * resuelto sobre la tabla reviews, que además tiene unique de
     * book_id + user_id).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Review, \App\Models\User>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    /**
     * Conversión de tipos al leer/escribir atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // guarda hasheada sin llamar a Hash::make a mano
        ];
    }
}

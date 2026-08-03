<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'responsable_id');
    }

    public function auditoriasComoLider(): HasMany
    {
        return $this->hasMany(Auditoria::class, 'auditor_lider_id');
    }

    public function accionesCorrectivasAsignadas(): HasMany
    {
        return $this->hasMany(AccionCorrectiva::class, 'responsable_id');
    }

    public function tieneRol(string $rol): bool
    {
        return $this->rol === $rol;
    }

    public function esAdmin(): bool
    {
        return $this->rol === 'Administrador del Sistema';
    }

    public function esConsultor(): bool
    {
        return $this->rol === 'Consultor';
    }

    public function esAuditor(): bool
    {
        return $this->rol === 'Auditor';
    }

    public function esAuditado(): bool
    {
        return $this->rol === 'Auditado';
    }

    public function esAltaDireccion(): bool
    {
        return $this->rol === 'Alta Dirección';
    }
}

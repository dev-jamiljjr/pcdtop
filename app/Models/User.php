<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification; // Sua notificação customizada
use Illuminate\Database\Eloquent\Relations\HasOne; // Importar o Trait para relacionamentos

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_perfil', // Corrigido para 'tipo_perfil' conforme usado no controlador
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Define o relacionamento One-to-One com o perfil Jovem.
     */
    public function jovem(): HasOne
    {
        return $this->hasOne(Jovem::class);
    }

    /**
     * Define o relacionamento One-to-One com o perfil Empresa.
     */
    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class);
    }
}

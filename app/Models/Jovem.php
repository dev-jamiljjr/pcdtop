<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jovem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'data_nascimento',
        'telefone',
        'cidade',
        'estado',
        'escolaridade',
        'deficiencia',
        'experiencia_profissional',
        'area_interesse',
        'curriculo_path',
    ];

    /**
     * Um jovem pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

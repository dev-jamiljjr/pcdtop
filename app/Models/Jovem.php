<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jovem extends Model
{
    use HasFactory;

    protected $table = 'jovens';

    protected $fillable = [
        'user_id',
        'cpf',
        'nome_completo',
        'data_nascimento',
        'genero',
        'deficiencia',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'telefone',
        'curriculo_path', // <<< CORREÇÃO AQUI
        'formacao_academica',
        'experiencia_profissional',
        'habilidades',
        'link_portfolio',
        'link_linkedin',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

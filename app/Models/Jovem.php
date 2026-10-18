<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jovem extends Model
{
    use HasFactory;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'jovens';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'data_nascimento',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'genero',
        'deficiencia',
        'formacao_academica',
        'experiencia_profissional',
        'habilidades',
        'link_portfolio',
        'link_linkedin',
        'curriculo_path', // Certifique-se que este campo está aqui para o upload de PDF
    ];

    /**
     * Um jovem pertence a um usuário.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

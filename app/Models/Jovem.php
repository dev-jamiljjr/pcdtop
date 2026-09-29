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
    protected $table = 'jovens'; // Adicione esta linha para especificar o nome correto da tabela

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

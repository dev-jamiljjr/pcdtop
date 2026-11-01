<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidatura extends Model
{
    use HasFactory;

    // Constantes para os status de candidatura (com a alteração)
    public const STATUS_PENDENTE = 'pendente';
    public const STATUS_VISUALIZADO = 'visualizado';
    public const STATUS_EM_ANALISE = 'em_analise';
    public const STATUS_ENTREVISTA = 'entrevista';
    public const STATUS_APROVADO = 'aprovado';
    public const STATUS_NAO_APROVADO = 'nao_aprovado'; // Alterado

    // Array associativo para labels de exibição dos status (com a alteração)
    public const STATUS_LABELS = [
        self::STATUS_PENDENTE => 'Pendente',
        self::STATUS_VISUALIZADO => 'Visualizado',
        self::STATUS_EM_ANALISE => 'Em Análise',
        self::STATUS_ENTREVISTA => 'Entrevista',
        self::STATUS_APROVADO => 'Aprovado',
        self::STATUS_NAO_APROVADO => 'Não Aprovado', // Alterado
    ];

    protected $fillable = [
        'jovem_id',
        'vaga_id',
        'status',
        'observacoes',
    ];

    /**
     * Define o relacionamento com o Jovem.
     */
    public function jovem(): BelongsTo
    {
        return $this->belongsTo(Jovem::class);
    }

    /**
     * Define o relacionamento com a Vaga.
     */
    public function vaga(): BelongsTo
    {
        return $this->belongsTo(Vaga::class);
    }

    /**
     * Retorna o label amigável para o status atual.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}

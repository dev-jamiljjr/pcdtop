<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Adicionado para relacionamentos um-para-muitos

class Vaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'titulo',
        'descricao',
        'requisitos',
        'localizacao',
        'tipo_contrato',
        'salario',
        'beneficios',
        'status',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Uma vaga pode ter muitas candidaturas.
     */
    public function candidaturas(): HasMany
    {
        return $this->hasMany(Candidatura::class);
    }
}

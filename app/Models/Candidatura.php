<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'jovem_id',
        'vaga_id',
        'status',
        'observacoes',
    ];

    public function jovem(): BelongsTo
    {
        return $this->belongsTo(Jovem::class);
    }

    public function vaga(): BelongsTo
    {
        return $this->belongsTo(Vaga::class);
    }
}

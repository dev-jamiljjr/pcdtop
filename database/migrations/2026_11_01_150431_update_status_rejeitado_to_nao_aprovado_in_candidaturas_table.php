<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Importar a classe DB

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Atualiza todos os registros que têm o status 'rejeitado' para 'nao_aprovado'
        DB::table('candidaturas')
            ->where('status', 'rejeitado')
            ->update(['status' => 'nao_aprovado']);
    }

    /**
     * Reverse the migrations.
     * (Opcional, mas boa prática: reverte a alteração se a migration for desfeita)
     */
    public function down(): void
    {
        // Se a migration for revertida, volta 'nao_aprovado' para 'rejeitado'
        // Isso é útil apenas em ambiente de desenvolvimento.
        DB::table('candidaturas')
            ->where('status', 'nao_aprovado')
            ->update(['status' => 'rejeitado']);
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Atualiza os status de 'rejeitado' para 'nao_aprovado'.
     */
    public function up(): void
    {
        DB::table('candidaturas')
            ->where('status', 'rejeitado')
            ->update(['status' => 'nao_aprovado']);
    }

    /**
     * Reverse the migrations.
     * Reverte os status de 'nao_aprovado' para 'rejeitado'.
     */
    public function down(): void
    {
        DB::table('candidaturas')
            ->where('status', 'nao_aprovado')
            ->update(['status' => 'rejeitado']);
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('candidaturas', function (Blueprint $table) {
            // CORREÇÃO: Removemos a linha que tentava apagar a chave estrangeira.
            // Agora, apenas adicionamos a chave correta, que está faltando no banco de dados.
            $table->foreign('vaga_id')
                  ->references('id')
                  ->on('vagas')
                  ->onDelete('restrict'); // Impede a exclusão em cascata indesejada.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidaturas', function (Blueprint $table) {
            // O método down agora só precisa apagar a chave que criamos no 'up'.
            $table->dropForeign(['vaga_id']);
            
            // Opcional, mas bom para consistência: recria a chave original com 'cascade'.
            $table->foreign('vaga_id')
                  ->references('id')
                  ->on('vagas')
                  ->onDelete('cascade');
        });
    }
};

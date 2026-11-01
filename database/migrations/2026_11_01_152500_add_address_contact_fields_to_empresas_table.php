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
        Schema::table('empresas', function (Blueprint $table) {
            // As colunas 'endereco', 'cidade', 'estado', 'telefone' e 'website'
            // já existem na migration create_empresas_table.
            // Adicionaremos apenas as colunas que estão faltando.
            $table->string('bairro')->nullable()->after('endereco');
            $table->string('cep', 10)->nullable()->after('estado'); // Ex: 99999-999
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn([
                'bairro',
                'cep',
            ]);
        });
    }
};

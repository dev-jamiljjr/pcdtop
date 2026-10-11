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
        Schema::table('vagas', function (Blueprint $table) {
            // Remove as colunas cidade e estado, pois localizacao é mais abrangente
            $table->dropColumn(['cidade', 'estado']);
            $table->string('localizacao')->after('requisitos');
            $table->string('tipo_contrato')->after('localizacao'); // CLT, PJ, Estágio, etc.
            $table->text('beneficios')->nullable()->after('salario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vagas', function (Blueprint $table) {
            $table->dropColumn(['localizacao', 'tipo_contrato', 'beneficios']);
            // Adiciona cidade e estado de volta, se necessário
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
        });
    }
};

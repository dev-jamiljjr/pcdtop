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
        Schema::table('empresa_contatos', function (Blueprint $table) {
            // Remove as restrições de unicidade existentes
            $table->dropUnique('empresa_contatos_cpf_unique');
            $table->dropUnique('empresa_contatos_email_unique');

            // Altera as colunas para permitir valores nulos
            $table->string('cpf', 14)->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresa_contatos', function (Blueprint $table) {
            $table->string('cpf', 14)->nullable(false)->unique()->change();
            $table->string('email')->nullable(false)->unique()->change();
        });
    }
};

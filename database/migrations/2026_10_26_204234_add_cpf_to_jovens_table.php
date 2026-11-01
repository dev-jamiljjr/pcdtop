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
        Schema::table('jovens', function (Blueprint $table) {
            // Adiciona a coluna 'cpf' após a coluna 'user_id'
            // Ela será uma string, única e pode ser nula (para registros antigos, se houver)
            $table->string('cpf', 11)->unique()->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jovens', function (Blueprint $table) {
            // Remove a coluna 'cpf' se precisarmos reverter a migration
            $table->dropColumn('cpf');
        });
    }
};

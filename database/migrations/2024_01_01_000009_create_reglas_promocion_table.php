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
        // Reglas de promoción - máximo de matriculados por ciclo y turno
        Schema::create('reglas_promocion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programa_estudio_id')->constrained('programas_estudio')->onDelete('cascade');
            $table->foreignId('turno_id')->constrained('turnos')->onDelete('cascade');
            $table->integer('ciclo');
            $table->integer('max_matriculados');
            $table->timestamps();

            $table->unique(['programa_estudio_id', 'turno_id', 'ciclo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reglas_promocion');
    }
};

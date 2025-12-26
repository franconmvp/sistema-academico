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
        // Matriculas por periodo lectivo
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('periodo_lectivo_id')->constrained('periodos_lectivos')->onDelete('cascade');
            $table->integer('ciclo');
            $table->enum('tipo', ['prematricula', 'matricula'])->default('prematricula');
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'cancelada'])->default('pendiente');
            $table->date('fecha_matricula');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['estudiante_id', 'periodo_lectivo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};

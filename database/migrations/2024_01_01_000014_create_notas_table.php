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
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matricula_detalle_id')->constrained('matricula_detalle')->onDelete('cascade');
            $table->decimal('nota_1', 4, 2)->nullable(); // Primera evaluación
            $table->decimal('nota_2', 4, 2)->nullable(); // Segunda evaluación
            $table->decimal('nota_3', 4, 2)->nullable(); // Tercera evaluación
            $table->decimal('nota_4', 4, 2)->nullable(); // Cuarta evaluación (si aplica)
            $table->decimal('promedio_parcial', 4, 2)->nullable();
            $table->decimal('examen_final', 4, 2)->nullable();
            $table->decimal('promedio_final', 4, 2)->nullable();
            $table->decimal('nota_recuperacion', 4, 2)->nullable();
            $table->decimal('nota_definitiva', 4, 2)->nullable();
            $table->enum('estado', ['aprobado', 'desaprobado', 'pendiente', 'retirado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas');
    }
};

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
        Schema::create('unidades_didacticas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_estudio_id')->constrained('planes_estudio')->onDelete('cascade');
            $table->string('codigo');
            $table->string('nombre');
            $table->integer('ciclo'); // Semestre/Ciclo al que pertenece (1-6)
            $table->integer('creditos');
            $table->integer('horas_semanales');
            $table->enum('tipo', ['obligatorio', 'electivo'])->default('obligatorio');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->unique(['plan_estudio_id', 'codigo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_didacticas');
    }
};

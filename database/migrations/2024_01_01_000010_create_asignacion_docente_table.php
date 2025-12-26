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
        // Asignación de docentes a unidades didácticas por periodo
        Schema::create('asignacion_docente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_id')->constrained('personal')->onDelete('cascade');
            $table->foreignId('unidad_didactica_id')->constrained('unidades_didacticas')->onDelete('cascade');
            $table->foreignId('periodo_lectivo_id')->constrained('periodos_lectivos')->onDelete('cascade');
            $table->foreignId('turno_id')->constrained('turnos')->onDelete('cascade');
            $table->string('aula')->nullable();
            $table->timestamps();

            $table->unique(['personal_id', 'unidad_didactica_id', 'periodo_lectivo_id', 'turno_id'], 'asignacion_docente_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_docente');
    }
};

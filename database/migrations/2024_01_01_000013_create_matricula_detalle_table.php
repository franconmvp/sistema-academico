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
        // Detalle de unidades didácticas matriculadas
        Schema::create('matricula_detalle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matricula_id')->constrained('matriculas')->onDelete('cascade');
            $table->foreignId('unidad_didactica_id')->constrained('unidades_didacticas')->onDelete('cascade');
            $table->foreignId('asignacion_docente_id')->nullable()->constrained('asignacion_docente')->onDelete('set null');
            $table->integer('numero_matricula')->default(1); // Vez que se matricula en esta UD
            $table->enum('estado', ['cursando', 'aprobado', 'desaprobado', 'retirado'])->default('cursando');
            $table->timestamps();

            $table->unique(['matricula_id', 'unidad_didactica_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matricula_detalle');
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignacion_docente_id',
        'dia',
        'hora_inicio',
        'hora_fin',
        'aula',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];

    /**
     * Get the asignacion docente
     */
    public function asignacionDocente(): BelongsTo
    {
        return $this->belongsTo(AsignacionDocente::class);
    }

    /**
     * Get formatted day name
     */
    public function getDiaNombreAttribute(): string
    {
        $dias = [
            'lunes' => 'Lunes',
            'martes' => 'Martes',
            'miercoles' => 'Miércoles',
            'jueves' => 'Jueves',
            'viernes' => 'Viernes',
            'sabado' => 'Sábado',
            'domingo' => 'Domingo',
        ];

        return $dias[$this->dia] ?? $this->dia;
    }
}

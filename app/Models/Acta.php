<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acta extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignacion_docente_id',
        'numero_acta',
        'fecha_generacion',
        'estado',
        'generado_por',
        'observaciones',
    ];

    protected $casts = [
        'fecha_generacion' => 'date',
    ];

    /**
     * Get the asignacion docente
     */
    public function asignacionDocente(): BelongsTo
    {
        return $this->belongsTo(AsignacionDocente::class);
    }

    /**
     * Get the user who generated the acta
     */
    public function generadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generado_por');
    }
}

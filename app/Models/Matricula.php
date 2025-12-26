<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'periodo_lectivo_id',
        'ciclo',
        'tipo',
        'estado',
        'fecha_matricula',
        'observaciones',
    ];

    protected $casts = [
        'fecha_matricula' => 'date',
    ];

    /**
     * Get the estudiante
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Get the periodo lectivo
     */
    public function periodoLectivo(): BelongsTo
    {
        return $this->belongsTo(PeriodoLectivo::class);
    }

    /**
     * Get the detalles de matricula
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(MatriculaDetalle::class);
    }

    /**
     * Scope for prematriculas
     */
    public function scopePrematricula($query)
    {
        return $query->where('tipo', 'prematricula');
    }

    /**
     * Scope for matriculas oficiales
     */
    public function scopeMatricula($query)
    {
        return $query->where('tipo', 'matricula');
    }

    /**
     * Scope for approved matriculas
     */
    public function scopeAprobada($query)
    {
        return $query->where('estado', 'aprobada');
    }
}

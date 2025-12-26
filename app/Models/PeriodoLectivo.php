<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodoLectivo extends Model
{
    use HasFactory;

    protected $table = 'periodos_lectivos';

    protected $fillable = [
        'nombre',
        'anio',
        'semestre',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Get the matriculas for this period
     */
    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }

    /**
     * Get the asignaciones docente for this period
     */
    public function asignacionesDocente(): HasMany
    {
        return $this->hasMany(AsignacionDocente::class);
    }

    /**
     * Scope for active period
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}

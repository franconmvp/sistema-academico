<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramaEstudio extends Model
{
    use HasFactory;

    protected $table = 'programas_estudio';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'duracion_semestres',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Get the planes de estudio for this programa
     */
    public function planesEstudio(): HasMany
    {
        return $this->hasMany(PlanEstudio::class);
    }

    /**
     * Get the estudiantes for this programa
     */
    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class);
    }

    /**
     * Get the reglas de promocion for this programa
     */
    public function reglasPromocion(): HasMany
    {
        return $this->hasMany(ReglaPromocion::class);
    }

    /**
     * Scope for active programs
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}

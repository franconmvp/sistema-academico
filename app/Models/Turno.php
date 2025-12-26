<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'hora_inicio',
        'hora_fin',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];

    /**
     * Get the estudiantes for this turno
     */
    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class);
    }

    /**
     * Get the reglas de promocion for this turno
     */
    public function reglasPromocion(): HasMany
    {
        return $this->hasMany(ReglaPromocion::class);
    }

    /**
     * Get the asignaciones docente for this turno
     */
    public function asignacionesDocente(): HasMany
    {
        return $this->hasMany(AsignacionDocente::class);
    }
}

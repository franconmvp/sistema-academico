<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'programa_estudio_id',
        'plan_estudio_id',
        'turno_id',
        'codigo_estudiante',
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'sexo',
        'telefono',
        'direccion',
        'email_personal',
        'ciclo_actual',
        'estado',
        'fecha_ingreso',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the programa de estudio
     */
    public function programaEstudio(): BelongsTo
    {
        return $this->belongsTo(ProgramaEstudio::class);
    }

    /**
     * Get the plan de estudio
     */
    public function planEstudio(): BelongsTo
    {
        return $this->belongsTo(PlanEstudio::class);
    }

    /**
     * Get the turno
     */
    public function turno(): BelongsTo
    {
        return $this->belongsTo(Turno::class);
    }

    /**
     * Get the matriculas
     */
    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }

    /**
     * Get the certificados
     */
    public function certificados(): HasMany
    {
        return $this->hasMany(Certificado::class);
    }

    /**
     * Get full name
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->apellido_paterno} {$this->apellido_materno}, {$this->nombres}";
    }

    /**
     * Scope for active students
     */
    public function scopeActivo($query)
    {
        return $query->where('estado', 'activo');
    }
}

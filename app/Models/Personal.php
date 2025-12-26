<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [
        'user_id',
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'tipo',
        'cargo',
        'especialidad',
        'grado_academico',
        'titulo_profesional',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'sexo',
        'fecha_ingreso',
        'condicion',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the asignaciones docente
     */
    public function asignacionesDocente(): HasMany
    {
        return $this->hasMany(AsignacionDocente::class);
    }

    /**
     * Get full name
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->apellido_paterno} {$this->apellido_materno}, {$this->nombres}";
    }

    /**
     * Scope for docentes
     */
    public function scopeDocentes($query)
    {
        return $query->where('tipo', 'docente');
    }

    /**
     * Scope for administrativos
     */
    public function scopeAdministrativos($query)
    {
        return $query->where('tipo', 'administrativo');
    }

    /**
     * Scope for jerarquicos
     */
    public function scopeJerarquicos($query)
    {
        return $query->where('tipo', 'jerarquico');
    }

    /**
     * Scope for active personal
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}

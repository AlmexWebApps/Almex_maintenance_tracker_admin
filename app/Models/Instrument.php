<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Instrument extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $table = 'intruments';

    protected $fillable = [
        'name',
        'type',
        'department',
        'location',
        'form',
        'Variable Unidad De Medida',
        'equipo',
        'brand',
        'model',
        'code',
        'emt_value',
        'emt_value_decimal',
        'emt_unit',
        'emt_symmetry',
        'file_manual',
        'types_of_criticality',
        'level_of_criticality',
        'last_calibration_date',
        'last_calibration_user',
        'next_calibration_date',
        'last_validation_date',
        'last_validation_user',
        'next_validation_date',
        'last_maintenance_date',
        'last_maintenance_user',
        'next_maintenance_date',
        'is_operational',
        'observations',
    ];

    protected $casts = [
        'emt_value_decimal' => 'decimal:4',
        'emt_symmetry' => 'bool',
        'is_operational' => 'bool',
        'last_calibration_date' => 'date',
        'next_calibration_date' => 'date',
        'last_validation_date' => 'date',
        'next_validation_date' => 'date',
        'last_maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
    ];

    protected $allowedSorts = [
        'name', 'type', 'department', 'location', 'brand', 'model',
        'types_of_criticality', 'level_of_criticality', 'next_calibration_date'
    ];

    protected $allowedFilters = [
        'name', 'type', 'department', 'location', 'brand', 'model',
        'types_of_criticality', 'level_of_criticality', 'is_operational'
    ];

    // 🔗 Relación general con eventos (calibraciones, validaciones, mantenimientos)
    public function events()
    {
        return $this->hasMany(InstrumentEvent::class);
    }

    // 🔍 Scopes convenientes para cada tipo
    public function calibrations()
    {
        return $this->events()->where('event_type', 'CALIBRACION');
    }

    public function validations()
    {
        return $this->events()->where('event_type', 'VALIDACION');
    }

    public function maintenances()
    {
        return $this->events()->where('event_type', 'MANTENIMIENTO');
    }
}

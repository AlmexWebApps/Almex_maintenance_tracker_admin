<?php

namespace App\Models;

use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo','tipo_item','equipo','marca','modelo','requiere_calibracion',
        'tipo','estado','emt_valor','emt_unidad','emt_simetrico',
        'ubicacion','forma',
        'ult_fecha_ultima','ult_fecha_proxima','ult_fecha_maxima','ult_dias_retraso',
        'ult_calibro','ult_reporte','ult_resultados','ult_adecuado_uso','ult_observaciones',
    ];

    protected $casts = [
        'tipo_item' => ItemType::class,
        'requiere_calibracion' => 'boolean',
        'emt_valor' => 'decimal:4',
        'ult_fecha_ultima' => 'date',
        'ult_fecha_proxima' => 'date',
        'ult_fecha_maxima' => 'date',
        'ult_adecuado_uso' => 'boolean',
    ];

    public function calibrations() {
        return $this->hasMany(Calibration::class);
    }
}

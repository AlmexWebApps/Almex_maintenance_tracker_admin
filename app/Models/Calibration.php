<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_item_id','fecha_calibracion','responsable','reporte',
        'resultados','adecuado','fecha_proxima','fecha_maxima'
    ];

    protected $casts = [
        'fecha_calibracion' => 'date',
        'fecha_proxima'     => 'date',
        'fecha_maxima'      => 'date',
        'adecuado'          => 'boolean',
    ];

    public function item() {
        return $this->belongsTo(CatalogItem::class, 'catalog_item_id');
    }
}

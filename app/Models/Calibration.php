<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class Calibration extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'catalog_item_id',
        'fecha_calibracion',
        'responsable',
        'reporte',
        'resultados',
        'observaciones',
        'adecuado',
        'fecha_proxima',
        'fecha_maxima',
    ];

    protected $casts = [
        'fecha_calibracion' => 'date',
        'fecha_proxima'     => 'date',
        'fecha_maxima'      => 'date',
        'adecuado'          => 'bool',
    ];

    protected $allowedSorts = [
        'fecha_calibracion','fecha_proxima','fecha_maxima','adecuado'
    ];

    protected $allowedFilters = [
        'responsable','reporte','adecuado'
    ];

    public function catalogItem()
    {
        return $this->belongsTo(CatalogItem::class);
    }
}

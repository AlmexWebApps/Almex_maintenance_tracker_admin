<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class InstrumentEvent extends Model
{
    use AsSource, HasFactory;

    protected $fillable = [
        'instrument_id',
        'event_type',
        'fecha_evento',
        'responsable',
        'reporte',
        'resultados',
        'adecuado',
        'fecha_proxima',
        'fecha_maxima',
    ];

    protected $casts = [
        'fecha_evento' => 'date',
        'fecha_proxima' => 'date',
        'fecha_maxima' => 'date',
        'adecuado' => 'bool',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}


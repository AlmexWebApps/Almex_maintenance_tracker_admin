<?php

namespace App\Observers;

use App\Models\Calibration;
use Carbon\Carbon;

class CalibrationObserver
{
    public function saved(Calibration $calibration): void
    {
        $item = $calibration->item()->lockForUpdate()->first();
        if (!$item) return;

        $ultima = $item->calibrations()->orderByDesc('fecha_calibracion')->first();

        if ($ultima) {
            $item->ult_fecha_ultima   = $ultima->fecha_calibracion;
            $item->ult_fecha_proxima  = $ultima->fecha_proxima;
            $item->ult_fecha_maxima   = $ultima->fecha_maxima;
            $item->ult_calibro        = $ultima->responsable;
            $item->ult_reporte        = $ultima->reporte;
            $item->ult_resultados     = $ultima->resultados;
            $item->ult_adecuado_uso   = $ultima->adecuado;
            $item->ult_observaciones  = $ultima->observaciones;
            $item->ult_dias_retraso   = $ultima->fecha_maxima
                ? Carbon::now()->startOfDay()->diffInDays($ultima->fecha_maxima, false)
                : null;
        } else {
            $item->fill([
                'ult_fecha_ultima'=>null,'ult_fecha_proxima'=>null,'ult_fecha_maxima'=>null,
                'ult_dias_retraso'=>null,'ult_calibro'=>null,'ult_reporte'=>null,
                'ult_resultados'=>null,'ult_adecuado_uso'=>null,'ult_observaciones'=>null,
            ]);
        }

        $item->save();
    }

    public function deleted(Calibration $calibration): void
    {
        $this->saved($calibration);
    }
}

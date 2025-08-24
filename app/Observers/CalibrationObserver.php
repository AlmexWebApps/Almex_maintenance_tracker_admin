<?php

namespace App\Observers;

use App\Models\Calibration;

class CalibrationObserver
{
    /**
     * Handle the Calibration "created" event.
     */
    public function created(Calibration $calibration): void
    {
        //
    }

    /**
     * Handle the Calibration "updated" event.
     */
    public function updated(Calibration $calibration): void
    {
        //
    }

    /**
     * Handle the Calibration "deleted" event.
     */
    public function deleted(Calibration $calibration): void
    {
        //
    }

    /**
     * Handle the Calibration "restored" event.
     */
    public function restored(Calibration $calibration): void
    {
        //
    }

    /**
     * Handle the Calibration "force deleted" event.
     */
    public function forceDeleted(Calibration $calibration): void
    {
        //
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instrument;
use App\Models\InstrumentEvent;

class InstrumentEventSeeder extends Seeder
{
    public function run(): void
    {
        $instruments = Instrument::all();

        foreach ($instruments as $instrument) {
            // Crea entre 1 y 3 calibraciones
            InstrumentEvent::factory(rand(1, 3))->create([
                'instrument_id' => $instrument->id,
                'event_type' => 'CALIBRACION',
            ]);

            // 1 validación
            InstrumentEvent::factory()->create([
                'instrument_id' => $instrument->id,
                'event_type' => 'VALIDACION',
            ]);

            // 1 mantenimiento
            InstrumentEvent::factory()->create([
                'instrument_id' => $instrument->id,
                'event_type' => 'MANTENIMIENTO',
            ]);
        }
    }
}

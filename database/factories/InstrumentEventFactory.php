<?php

namespace Database\Factories;

use App\Models\Instrument;
use App\Models\InstrumentEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstrumentEventFactory extends Factory
{
    protected $model = InstrumentEvent::class;

    public function definition(): array
    {
        $eventType = $this->faker->randomElement(['CALIBRACION', 'VALIDACION', 'MANTENIMIENTO']);
        $fechaEvento = $this->faker->dateTimeBetween('-1 year', 'now');

        return [
            'instrument_id' => Instrument::factory(),
            'event_type' => $eventType,
            'fecha_evento' => $fechaEvento,
            'responsable' => $this->faker->name,
            'reporte' => strtoupper($this->faker->bothify('REP-###')),
            'resultados' => $this->faker->sentence(10),
            'adecuado' => $this->faker->boolean(85),
            'fecha_proxima' => $this->faker->dateTimeBetween('now', '+1 year'),
            'fecha_maxima' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
        ];
    }
}

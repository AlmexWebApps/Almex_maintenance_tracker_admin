<?php

namespace Database\Factories;

use App\Models\Instrument;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstrumentFactory extends Factory
{
    protected $model = Instrument::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'type' => $this->faker->randomElement(['INSTRUMENTO', 'PLANO']),
            'department' => $this->faker->randomElement(['Producción', 'Calidad', 'Laboratorio']),
            'location' => $this->faker->city,
            'form' => $this->faker->randomElement(['Intrumento Electronico', 'Intrumento Simple']),
            'Variable Unidad De Medida' => $this->faker->randomElement([
                'Temperatura', 'Presión', 'Peso', 'Humedad', 'Flujo', 'Concentración', 'pH', 'N/A'
            ]),
            'equipo' => strtoupper($this->faker->word),
            'brand' => $this->faker->company,
            'model' => $this->faker->bothify('MOD-###'),
            'code' => strtoupper($this->faker->unique()->bothify('INS-#####')),
            'emt_value' => $this->faker->randomNumber(2),
            'emt_value_decimal' => $this->faker->randomFloat(4, 0.001, 99.9999),
            'emt_unit' => $this->faker->randomElement(['°C', 'bar', 'kg', 'L/min']),
            'emt_symmetry' => $this->faker->boolean(70),
            'file_manual' => 'N/A',
            'types_of_criticality' => $this->faker->randomElement(['NO_CRITICO', 'CRITICO']),
            'level_of_criticality' => $this->faker->randomElement(['BAJA', 'MEDIA', 'ALTA']),
            'last_calibration_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'next_calibration_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'last_validation_date' => $this->faker->optional()->dateTimeBetween('-2 years', 'now'),
            'next_validation_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'last_maintenance_date' => $this->faker->optional()->dateTimeBetween('-2 years', 'now'),
            'next_maintenance_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'is_operational' => $this->faker->boolean(90),
            'observations' => $this->faker->sentence(),
        ];
    }
}

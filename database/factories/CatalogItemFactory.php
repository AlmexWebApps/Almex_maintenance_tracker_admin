<?php

namespace Database\Factories;

use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogItemFactory extends Factory
{
    public function definition(): array {
        return [
            'codigo' => $this->faker->unique()->numerify('########'),
            'tipo_item' => $this->faker->randomElement([ItemType::INSTRUMENTO, ItemType::PLANO]),
            'equipo' => strtoupper($this->faker->bothify('FT-????')),
            'marca' => $this->faker->company(),
            'modelo' => $this->faker->bothify('####????'),
            'requiere_calibracion' => true,
            'tipo' => 'NO_CRITICO',
            'estado' => 'BAJA',
            'emt_valor' => 1.0000,
            'emt_unidad' => 'psi',
            'emt_simetrico' => true,
            'ubicacion' => 'Caldera No.1',
            'forma' => 'Instrumento Electrónico',
        ];
    }
}

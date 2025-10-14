<?php

namespace Database\Seeders;

use App\Models\Calibration;
use App\Models\CatalogItem;
use Illuminate\Database\Seeder;

class CalibrationSeeder extends Seeder
{
    public function run(): void
    {
        Calibration::factory()
            ->for(CatalogItem::factory(), 'item') // 👈 relación belongsTo del hijo
            ->create();
    }
}

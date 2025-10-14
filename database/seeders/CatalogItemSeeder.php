<?php

namespace Database\Seeders;

use App\Models\Calibration;
use App\Models\CatalogItem;
use Illuminate\Database\Seeder;

class CatalogItemSeeder extends Seeder
{
    public function run(): void
    {
        CatalogItem::factory()
            ->has(Calibration::factory()->count(2), 'calibrations') // 👈 usa 'calibrations'
            ->count(100)
            ->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\CatalogItem;
use App\Models\Calibration;
use Illuminate\Database\Seeder;

class CatalogItemSeeder extends Seeder
{
    public function run(): void
    {
        CatalogItem::factory()
            ->has(Calibration::factory()->count(2))
            ->count(2)
            ->create();
    }
}

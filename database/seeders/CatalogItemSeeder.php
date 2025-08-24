<?php

namespace Database\Seeders;

use App\Models\CatalogItem;
use App\Models\Calibration;
use Illuminate\Database\Seeder;

class CatalogItemSeeder extends Seeder
{
    public function run(): void
    {
        CatalogItem::factory()->count(2)->create()
            ->each(function ($item) {
                Calibration::factory()->count(2)->create([
                    'catalog_item_id' => $item->id
                ]);
            });
    }
}

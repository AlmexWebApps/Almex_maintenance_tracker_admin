<?php

use App\Enums\ItemType;
use App\Models\CatalogItem;
use App\Models\Calibration;
use Database\Seeders\CatalogItemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

it('catalog item has many calibrations', function () {
    seed(CatalogItemSeeder::class);

    $item = CatalogItem::first();

    expect($item->calibrations)->toHaveCount(2);
});

it('calibration belongs to catalog item', function () {
    $calibration = Calibration::factory()->create();

    expect($calibration->item)->toBeInstanceOf(CatalogItem::class);
});

it('casts attributes correctly', function () {
    $item = CatalogItem::factory()->create([
        'tipo_item' => ItemType::PLANO,
        'requiere_calibracion' => true,
        'emt_valor' => 1.2345,
        'ult_fecha_ultima' => '2024-01-01',
        'ult_adecuado_uso' => true,
    ]);

    expect($item->tipo_item)->toBe(ItemType::PLANO)
        ->and($item->requiere_calibracion)->toBeTrue()
        ->and($item->emt_valor)->toBe('1.2345')
        ->and($item->ult_fecha_ultima)->toBeInstanceOf(Carbon::class)
        ->and($item->ult_adecuado_uso)->toBeTrue();

    $calibration = Calibration::factory()->create([
        'fecha_calibracion' => '2024-02-02',
        'adecuado' => false,
    ]);

    expect($calibration->fecha_calibracion)->toBeInstanceOf(Carbon::class)
        ->and($calibration->adecuado)->toBeFalse();
});

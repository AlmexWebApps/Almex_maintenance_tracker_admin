<?php

use App\Models\Calibration;
use App\Models\CatalogItem;
use Database\Seeders\CatalogItemSeeder;

it('performs full CRUD for catalog items', function () {
    $this->seed(CatalogItemSeeder::class);

    $data = CatalogItem::factory()->make()->toArray();

    $response = $this->postJson('/api/items', $data);
    $response->assertCreated()->assertJsonPath('data.codigo', $data['codigo']);

    $itemId = $response->json('data.id');

    $this->getJson("/api/items/{$itemId}")
        ->assertOk()
        ->assertJsonPath('data.codigo', $data['codigo']);

    $update = ['equipo' => 'Equipo Actualizado'];
    $this->putJson("/api/items/{$itemId}", $update)
        ->assertOk()
        ->assertJsonPath('data.equipo', 'Equipo Actualizado');

    $this->deleteJson("/api/items/{$itemId}")
        ->assertNoContent();

    $this->assertDatabaseMissing('catalog_items', ['id' => $itemId]);
});

it('performs CRUD for calibrations of an item', function () {
    $item = CatalogItem::factory()->create();

    $calibrationData = Calibration::factory()->make(['catalog_item_id' => $item->id])->toArray();
    unset($calibrationData['catalog_item_id']);

    $create = $this->postJson("/api/items/{$item->id}/calibrations", $calibrationData);
    $create->assertCreated();
    $calibrationId = $create->json('data.id');
    $this->assertDatabaseHas('calibrations', ['id' => $calibrationId, 'catalog_item_id' => $item->id]);

    $updateData = [
        'fecha_calibracion' => $calibrationData['fecha_calibracion'],
        'responsable' => 'Nuevo Responsable',
    ];

    $this->putJson("/api/items/{$item->id}/calibrations/{$calibrationId}", $updateData)
        ->assertOk()
        ->assertJsonPath('data.responsable', 'Nuevo Responsable');

    $this->deleteJson("/api/items/{$item->id}/calibrations/{$calibrationId}")
        ->assertNoContent();

    $this->assertDatabaseMissing('calibrations', ['id' => $calibrationId]);
});

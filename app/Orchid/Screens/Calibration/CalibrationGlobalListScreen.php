<?php

namespace App\Orchid\Screens\Calibration;

use App\Models\Calibration;
use App\Models\CatalogItem;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Link;

class CalibrationGlobalListScreen extends Screen
{
    public $name = 'Calibraciones (Global)';
    public $description = 'Todas las calibraciones registradas en el sistema';

    public function query(): array
    {
        return [
            'calibrations' => Calibration::query()
                ->with('catalogItem')
                ->defaultSort('fecha_calibracion', 'desc')
                ->paginate(),
        ];
    }

    public function commandBar(): array
    {
        return [
            // Si quieres permitir crear desde aquí, podemos abrir un modal para seleccionar el CatalogItem.
            // Para mantenerlo simple, crea desde el ítem (lista anidada).
            Link::make('Ir al Catálogo de Ítems')->icon('list')->route('platform.catalog_items'),
        ];
    }

    public function layout(): array
    {
        return [
            new class extends Table {
                protected $target = 'calibrations';

                protected function columns(): array
                {
                    return [
                        TD::make('catalog_item_id', 'Ítem')
                            ->render(function (Calibration $c) {
                                /** @var CatalogItem|null $item */
                                $item = $c->catalogItem;
                                if (!$item) return '—';
                                return Link::make("{$item->codigo} · {$item->equipo}")
                                    ->route('platform.catalog_items.edit', $item->id);
                            })
                            ->width('300px'),

                        TD::make('fecha_calibracion', 'Fecha Cal.')
                            ->sort()
                            ->filter(TD::FILTER_DATE),

                        TD::make('responsable', 'Responsable')
                            ->filter(),

                        TD::make('reporte', 'Reporte/Folio')
                            ->defaultHidden(),

                        TD::make('adecuado', 'Adecuado')
                            ->sort()
                            ->render(fn (Calibration $c) => $c->adecuado ? 'Sí' : 'No')
                            ->filter(TD::FILTER_TEXT),

                        TD::make('fecha_proxima', 'Próxima')
                            ->sort()
                            ->filter(TD::FILTER_DATE),

                        TD::make('fecha_maxima', 'Máxima')
                            ->sort()
                            ->filter(TD::FILTER_DATE),

                        TD::make('Acciones')->alignRight()->render(function (Calibration $c) {
                            return Link::make('Editar')
                                ->icon('pencil')
                                // Reutilizamos el screen anidado para editar:
                                ->route('platform.catalog_items.calibrations.edit', [$c->catalog_item_id, $c->id]);
                        }),
                    ];
                }
            },
        ];
    }
}

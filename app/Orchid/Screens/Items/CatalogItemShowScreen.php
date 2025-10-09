<?php

namespace App\Orchid\Screens\Items;

use App\Models\CatalogItem;
use App\Models\Calibration;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;     // Facade con ::rows(), ::legend(), ::tabs(), etc.
use Orchid\Screen\Layouts\Legend;      // Layout de solo lectura
use Orchid\Screen\Layouts\Table;       // Layout de tabla
use Orchid\Screen\Sight;               // Campos de Legend
use Orchid\Screen\TD;                  // Columnas de Table
use Orchid\Screen\Actions\Link;

class CatalogItemShowScreen extends Screen
{
    public $name = 'Detalle de Ítem';
    public $description = 'Ficha técnica y últimos mantenimientos';

    protected CatalogItem $catalogItem;

    public function query(CatalogItem $catalogItem): array
    {
        $this->catalogItem = $catalogItem;
        $this->name = "Detalle: {$catalogItem->codigo}";

        return [
            'catalogItem'  => $catalogItem,
            'calibrations' => $catalogItem->calibrations()
                ->orderByDesc('fecha_calibracion')
                ->limit(10)
                ->get(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Editar ítem')
                ->icon('pencil')
                ->route('platform.catalog_items.edit', $this->catalogItem->id),

            Link::make('Nueva calibración')
                ->icon('plus')
                ->route('platform.catalog_items.calibrations.create', $this->catalogItem->id),

            Link::make('Ver todas las calibraciones')
                ->icon('wrench')
                ->route('platform.catalog_items.calibrations', $this->catalogItem->id),

            Link::make('Volver al listado')
                ->icon('arrow-left')
                ->route('platform.catalog_items'),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::legend('catalogItem',[
                    Sight::make('codigo', 'Código'),
                    Sight::make('tipo_item', 'Tipo de Ítem'),
                    Sight::make('equipo', 'Equipo'),
                    Sight::make('marca', 'Marca'),
                    Sight::make('modelo', 'Modelo'),
                    Sight::make('requiere_calibracion', 'Requiere Calibración')
                        ->render(fn ($i) => $i->requiere_calibracion ? 'Sí' : 'No'),
                    Sight::make('tipo', 'Criticidad'),
                    Sight::make('estado', 'Estado'),

                    Sight::make('emt_valor', 'EMT - Valor'),
                    Sight::make('emt_unidad', 'EMT - Unidad'),
                    Sight::make('emt_simetrico', 'EMT Simétrico')
                        ->render(fn ($i) => is_null($i->emt_simetrico) ? '—' : ($i->emt_simetrico ? 'Sí' : 'No')),

                    Sight::make('ubicacion', 'Ubicación'),
                    Sight::make('forma', 'Forma'),

                    Sight::make('ult_fecha_ultima', 'Última Cal.'),
                    Sight::make('ult_fecha_proxima', 'Próxima Cal.'),
                    Sight::make('ult_fecha_maxima', 'Fecha Máxima'),
                    Sight::make('ult_dias_retraso', 'Días de Retraso'),
                    Sight::make('ult_calibro', 'Calibró'),
                    Sight::make('ult_reporte', 'Reporte/Folio'),
                    Sight::make('ult_adecuado_uso', 'Adecuado p/uso')
                        ->render(fn ($i) => is_null($i->ult_adecuado_uso) ? '—' : ($i->ult_adecuado_uso ? 'Sí' : 'No')),
                    Sight::make('ult_resultados', 'Resultados'),
                    Sight::make('ult_observaciones', 'Observaciones')
            ]),
            Layout::table('calibrations', [
                TD::make('fecha_calibracion', 'Fecha Cal.')->sort(),
                TD::make('responsable', 'Responsable'),
                TD::make('reporte', 'Reporte/Folio'),
                TD::make('adecuado', 'Adecuado')->render(fn (Calibration $c) => $c->adecuado ? 'Sí' : 'No'),
                TD::make('fecha_proxima', 'Próxima'),
                TD::make('fecha_maxima', 'Máxima'),
                TD::make('Acciones')->alignRight()->render(function (Calibration $c) {
                    return Link::make('Editar')
                        ->icon('pencil')
                        ->route('platform.catalog_items.calibrations.edit', [$c->catalog_item_id, $c->id]);
                }),
            ])
        ];
    }
}

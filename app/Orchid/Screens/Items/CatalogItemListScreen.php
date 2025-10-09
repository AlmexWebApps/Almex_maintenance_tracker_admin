<?php

namespace App\Orchid\Screens\Items;

use App\Models\CatalogItem;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CatalogItemListScreen extends Screen
{
    public $name = 'Catálogo de Instrumentos';
    public $description = 'Gestión de instrumentos/planos';

    public function query(): array
    {
        return [
            'items' => CatalogItem::paginate(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Nuevo')
                ->icon('plus')
                ->route('platform.catalog_items.create')
        ];
    }

    public function layout(): array
    {
        return [
            new class extends Table {
                protected $target = 'items';

                protected function columns(): array
                {
                    return [
                        TD::make('codigo','Código')->sort()->filter()->render(function (CatalogItem $i) {
                            return Link::make($i->codigo)
                                ->route('platform.catalog_items.view', $i->id);
                        }),
                        TD::make('equipo','Equipo')->sort()->filter(),
                        TD::make('marca','Marca')->filter(),
                        TD::make('estado','Estado')->sort()->filter(),
                        TD::make('tipo_item','Tipo Item')->filter(),
                        TD::make('tipo','Criticidad')->filter(),
                        TD::make('ult_fecha_proxima','Próxima Cal.')->sort(),
                        TD::make('Acciones')->render(function (CatalogItem $i) {
                            return Link::make('Editar')->icon('pencil')->route('platform.catalog_items.edit', $i->id);
                        }),
                    ];
                }
            },
        ];
    }
}


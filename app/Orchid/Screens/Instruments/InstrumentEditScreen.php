<?php

namespace App\Orchid\Screens\Instruments;

use App\Models\Instrument;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class InstrumentEditScreen extends Screen
{
    public $name = 'Instrumento';
    public $description = 'Crear o editar información del instrumento.';
    public $instrument;

    public function query(Instrument $instrument): array
    {
        return [
            'instrument' => $instrument,
        ];
    }

    public function commandBar(): array
    {
//        return [
//            Button::make('💾 Guardar')->icon('check')->method('save'),
//        ];
        return [
            Button::make('Guardar')->icon('check')->method('save')->canSee(true),
//            Button::make('Eliminar')->icon('trash')->method('remove')
//                ->confirm('¿Eliminar definitivamente este ítem?')
//                ->canSee($this->exists),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('instrument.name')->title('Nombre')->required(),
                Select::make('instrument.type')->options([
                    'INSTRUMENTO' => 'Instrumento',
                    'PLANO' => 'Plano',
                ])->title('Tipo'),
                Input::make('instrument.department')->title('Departamento'),
                Input::make('instrument.location')->title('Ubicación'),
                Input::make('instrument.form')->title('Forma'),
                Input::make('instrument.Variable Unidad De Medida')->title('Variable / Unidad'),
                Input::make('instrument.brand')->title('Marca'),
                Input::make('instrument.model')->title('Modelo'),
                Input::make('instrument.code')->title('Código')->required(),
                Select::make('instrument.level_of_criticality')->options([
                    'BAJA' => 'Baja',
                    'MEDIA' => 'Media',
                    'ALTA' => 'Alta',
                ])->title('Nivel de criticidad'),
                Select::make('instrument.types_of_criticality')->options([
                    'NO_CRITICO' => 'No crítico',
                    'CRITICO' => 'Crítico',
                ])->title('Tipo de criticidad'),
                TextArea::make('instrument.observations')->title('Observaciones'),
            ]),
        ];
    }

    public function save(Request $request, Instrument $instrument)
    {
        $instrument->fill($request->get('instrument'))->save();

        Alert::info('Instrumento guardado correctamente.');
        return redirect()->route('platform.instruments.list');
    }
}

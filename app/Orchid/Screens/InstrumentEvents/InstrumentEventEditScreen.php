<?php

namespace App\Orchid\Screens\InstrumentEvents;

use App\Models\InstrumentEvent;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class InstrumentEventEditScreen extends Screen
{
    public $name = 'Registrar Evento';
    public $description = 'Agregar o editar un evento de calibración, validación o mantenimiento.';
    public $instrumentEvent;

    public function query(InstrumentEvent $instrumentEvent): array
    {
        return [
            'instrumentEvent' => $instrumentEvent,
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('💾 Guardar')->icon('check')->method('save'),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Select::make('instrumentEvent.instrument_id')
                    ->fromModel(Instrument::class, 'code')
                    ->title('Instrumento')
                    ->required(),
                Select::make('instrumentEvent.event_type')
                    ->options([
                        'CALIBRACION' => 'Calibración',
                        'VALIDACION' => 'Validación',
                        'MANTENIMIENTO' => 'Mantenimiento',
                    ])->title('Tipo de evento')->required(),
                DateTimer::make('instrumentEvent.fecha_evento')->title('Fecha del evento')->required(),
                Input::make('instrumentEvent.responsable')->title('Responsable'),
                Input::make('instrumentEvent.reporte')->title('Reporte'),
                TextArea::make('instrumentEvent.resultados')->title('Resultados'),
                Select::make('instrumentEvent.adecuado')
                    ->options([1 => 'Adecuado', 0 => 'No adecuado'])
                    ->title('Evaluación'),
                DateTimer::make('instrumentEvent.fecha_proxima')->title('Próxima fecha'),
                DateTimer::make('instrumentEvent.fecha_maxima')->title('Fecha máxima'),
            ]),
        ];
    }

    public function save(Request $request, InstrumentEvent $instrumentEvent)
    {
        $instrumentEvent->fill($request->get('instrumentEvent'))->save();

        Alert::info('Evento guardado correctamente.');
        return redirect()->route('platform.instrument-events.list');
    }
}

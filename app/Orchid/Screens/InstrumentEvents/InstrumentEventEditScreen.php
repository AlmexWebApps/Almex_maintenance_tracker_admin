<?php

namespace App\Orchid\Screens\InstrumentEvents;

use App\Models\Instrument;
use App\Models\InstrumentEvent;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class InstrumentEventEditScreen extends Screen
{
    public $name = 'Evento de Instrumento';
    public $description = 'Registrar o editar calibraciones, validaciones o mantenimientos.';

    public $instrumentEvent;

    public function query(InstrumentEvent $instrumentEvent): array
    {
        return [
            'instrumentEvent' => $instrumentEvent->exists
                ? $instrumentEvent->load('instrument')
                : $instrumentEvent,
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('💾 Guardar')
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                // 🔍 Selector con búsqueda de instrumentos
                Select::make('instrumentEvent.instrument_id')
                    ->fromQuery(Instrument::query(), 'name', 'id')
                    ->title('Instrumento')
                    ->help('Selecciona el instrumento al que pertenece este evento.')
                    ->required(),

                Select::make('instrumentEvent.event_type')
                    ->options([
                        'CALIBRACION' => '📏 Calibración',
                        'VALIDACION' => '✅ Validación',
                        'MANTENIMIENTO' => '🛠️ Mantenimiento',
                    ])
                    ->title('Tipo de Evento')
                    ->required(),

                DateTimer::make('instrumentEvent.fecha_evento')
                    ->title('Fecha del Evento')
                    ->required(),

                Input::make('instrumentEvent.responsable')
                    ->title('Responsable'),

                Input::make('instrumentEvent.reporte')
                    ->title('Reporte'),

                TextArea::make('instrumentEvent.resultados')
                    ->title('Resultados')
                    ->rows(3),

                Select::make('instrumentEvent.adecuado')
                    ->options([
                        1 => '✅ Adecuado',
                        0 => '❌ No adecuado',
                    ])
                    //->empty('Seleccionar...', null)
                    ->title('Evaluación'),

                DateTimer::make('instrumentEvent.fecha_proxima')->title('Fecha Próxima'),
                DateTimer::make('instrumentEvent.fecha_maxima')->title('Fecha Máxima'),
            ]),
        ];
    }

    public function save(Request $request, InstrumentEvent $instrumentEvent)
    {
        $validated = $request->validate([
            'instrumentEvent.instrument_id' => 'required|exists:intruments,id',
            'instrumentEvent.event_type' => 'required|in:CALIBRACION,VALIDACION,MANTENIMIENTO',
            'instrumentEvent.fecha_evento' => 'required|date',
            'instrumentEvent.responsable' => 'nullable|string|max:255',
            'instrumentEvent.reporte' => 'nullable|string|max:255',
            'instrumentEvent.resultados' => 'nullable|string',
            'instrumentEvent.adecuado' => 'boolean',
            'instrumentEvent.fecha_proxima' => 'nullable|date',
            'instrumentEvent.fecha_maxima' => 'nullable|date',
        ]);

        $instrumentEvent->fill($validated['instrumentEvent']);
        $instrumentEvent->save();

        Alert::success('Evento guardado correctamente.');

        // 🔁 Redirección inteligente según origen
        if ($instrumentEvent->instrument_id) {
            return redirect()->route('platform.instruments.view', $instrumentEvent->instrument_id);
        }

        return redirect()->route('platform.instrument_events.global');
    }
}

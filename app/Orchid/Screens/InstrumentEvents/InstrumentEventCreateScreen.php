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

class InstrumentEventCreateScreen extends Screen
{
    public $name = 'Registrar Nuevo Evento de Instrumento';
    public $description = 'Permite registrar calibraciones, validaciones o mantenimientos seleccionando el instrumento mediante búsqueda.';

    public function query(): array
    {
        return [];
    }

    public function commandBar(): array
    {
        return [
            Button::make('💾 Guardar Evento')
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
                    ->title('Instrumento')
                    ->help('Busca y selecciona un instrumento por nombre o código.')
                    ->fromQuery(Instrument::query(), 'name', 'id')
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
                    ->title('Responsable')
                    ->placeholder('Nombre del técnico o responsable'),

                Input::make('instrumentEvent.reporte')
                    ->title('Reporte')
                    ->placeholder('Número o código del reporte'),

                TextArea::make('instrumentEvent.resultados')
                    ->title('Resultados')
                    ->rows(3),

                Select::make('instrumentEvent.adecuado')
                    ->title('Evaluación')
                    ->options([
                        1 => '✅ Adecuado',
                        0 => '❌ No adecuado',
                    ]),
                    //->empty('Seleccionar...', null),

                DateTimer::make('instrumentEvent.fecha_proxima')
                    ->title('Fecha Próxima (opcional)'),

                DateTimer::make('instrumentEvent.fecha_maxima')
                    ->title('Fecha Máxima (opcional)'),
            ]),
        ];
    }

    public function save(Request $request)
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

        InstrumentEvent::create($validated['instrumentEvent']);

        Alert::success('Evento creado correctamente.');
        return redirect()->route('platform.instrument_events.global');
    }
}

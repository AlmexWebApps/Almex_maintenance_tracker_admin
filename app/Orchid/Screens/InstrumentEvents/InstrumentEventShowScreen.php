<?php

namespace App\Orchid\Screens\InstrumentEvents;

use App\Models\InstrumentEvent;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;

class InstrumentEventShowScreen extends Screen
{
    public $name = 'Detalle del Evento de Instrumento';
    public $description = 'Visualiza la información completa de un evento de calibración, validación o mantenimiento.';

    public $instrumentEvent;

    public function query(InstrumentEvent $instrumentEvent): array
    {
        return [
            'instrumentEvent' => $instrumentEvent->load('instrument'),
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('✏️ Editar Evento')
                ->icon('pencil')
                ->route('platform.instruments.events.edit', [
                    'instrument' => $this->instrumentEvent->instrument_id,
                    'instrumentEvent' => $this->instrumentEvent->id,
                ]),
        ];
    }

    public function layout(): array
    {
        return [
            // 🔹 Datos principales del evento
            Layout::legend('instrumentEvent', [
                Sight::make('event_type', 'Tipo de Evento')->render(fn($e) => match ($e->event_type) {
                    'CALIBRACION' => '📏 Calibración',
                    'VALIDACION' => '✅ Validación',
                    'MANTENIMIENTO' => '🛠️ Mantenimiento',
                    default => $e->event_type,
                }),
                Sight::make('fecha_evento', 'Fecha del Evento')->render(fn($e) => optional($e->fecha_evento)->format('Y-m-d')),
                Sight::make('responsable', 'Responsable'),
                Sight::make('reporte', 'Reporte'),
                Sight::make('resultados', 'Resultados'),
                Sight::make('adecuado', 'Evaluación')->render(fn($e) => $e->adecuado ? '✅ Adecuado' : '❌ No adecuado'),
                Sight::make('fecha_proxima', 'Próxima Fecha')->render(fn($e) => optional($e->fecha_proxima)->format('Y-m-d')),
                Sight::make('fecha_maxima', 'Fecha Máxima')->render(fn($e) => optional($e->fecha_maxima)->format('Y-m-d')),
                Sight::make('created_at', 'Creado el')->render(fn($e) => $e->created_at->format('Y-m-d H:i')),
                Sight::make('updated_at', 'Última actualización')->render(fn($e) => $e->updated_at->format('Y-m-d H:i')),
            ])->title('Información del Evento'),

            // 🔹 Relación con el instrumento
            Layout::legend('instrumentEvent.instrument', [
                Sight::make('code', 'Código'),
                Sight::make('name', 'Nombre'),
                Sight::make('department', 'Departamento'),
                Sight::make('brand', 'Marca'),
                Sight::make('model', 'Modelo'),
            ])->title('Instrumento Asociado'),
        ];
    }
}

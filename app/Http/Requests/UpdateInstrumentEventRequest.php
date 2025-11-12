<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstrumentEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_type' => 'sometimes|in:CALIBRACION,VALIDACION,MANTENIMIENTO',
            'fecha_evento' => 'nullable|date',
            'responsable' => 'nullable|string|max:255',
            'reporte' => 'nullable|string|max:255',
            'resultados' => 'nullable|string',
            'adecuado' => 'boolean',
            'fecha_proxima' => 'nullable|date',
            'fecha_maxima' => 'nullable|date',
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreInstrumentRequest;
use App\Http\Requests\UpdateInstrumentRequest;
use App\Http\Requests\StoreInstrumentEventRequest;
use App\Http\Requests\UpdateInstrumentEventRequest;

class InstrumentController extends Controller
{
    /**
     * 📋 Listar todos los instrumentos
     */
    public function index()
    {
        $instruments = Instrument::with('events')->get();

        return response()->json([
            'meta' => [
                'total' => $instruments->count(),
            ],
            'data' => $instruments,
        ]);
    }

    /**
     * ➕ Crear nuevo instrumento
     */
    public function store(Request $request)
    {
        $instrument = Instrument::create($request->validated());

        return response()->json([
            'message' => 'Instrumento creado correctamente.',
            'data' => $instrument,
        ], Response::HTTP_CREATED);
    }

    /**
     * 🔍 Mostrar un instrumento específico
     */
    public function show(Instrument $instrument)
    {
        $instrument->load('events');

        return response()->json($instrument);
    }

    /**
     * ✏️ Actualizar un instrumento
     */
    public function update(Request $request, Instrument $instrument)
    {
        $instrument->update($request->validated());

        return response()->json([
            'message' => 'Instrumento actualizado correctamente.',
            'data' => $instrument,
        ]);
    }

    /**
     * 🗑️ Eliminar un instrumento
     */
    public function destroy(Instrument $instrument)
    {
        $instrument->delete();

        return response()->json(['message' => 'Instrumento eliminado correctamente.']);
    }
}

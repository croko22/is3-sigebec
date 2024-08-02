<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScholarshipCall;
use App\Models\Scholarship;
use App\Http\Resources\ConvocatoriaResource;
use App\Http\Requests\Convocatoria\IndexRequest as ConvocatoriaIndexRequest;
use App\Http\Requests\Convocatoria\CreateRequest as ConvocatoriaCreateRequest;
use App\Http\Requests\Convocatoria\UpdateRequest as ConvocatoriaUpdateRequest;

use Illuminate\Http\Request;

class ConvocatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ConvocatoriaIndexRequest $request)
    {
        $convocatorias = ScholarshipCall::query();
        if($request->has('nombre')) {
            $convocatorias->where('name', 'like', '%' . request('nombre') . '%');
        }
        if($request->has('descripcion')) {
            $convocatorias->where('description', 'like', '%' . request('descripcion') . '%');
        }
        if($request->has('con_becas')) {
            $convocatorias->with('scholarship');
        }
        if($request->has('pasadas')) {
            $convocatorias->where('end_date', '<', now());
        }
        if($request->has('activas')) {
            $convocatorias->where('start_date', '<', now())->where('end_date', '>', now());
        }
        if($request->has('proximas')) {
            $convocatorias->where('start_date', '>', now());
        }
        $convocatorias->orderBy('start_date', 'desc')->get();
        if($convocatorias->count() == 0) {
            return response()->json(['message' => 'No se encontraron convocatorias'], 404);
        }
        return ConvocatoriaResource::collection($convocatorias->get());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConvocatoriaCreateRequest $request)
    {
        $validated = $request->validated();
        $beca = Scholarship::find($validated['beca_id']);
        if(!$beca) {
            return response()->json(['message' => 'No se encontró la beca'], 404);
        }
        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        $inicio = explode('-', $validated['inicio']);
        $mes = $meses[$inicio[1] - 1];
        $convocatoria = ScholarshipCall::create([
            'name' => $beca->name." ".$mes." ". $inicio[0],
            'description' => $validated['descripcion'],
            'start_date' => $validated['inicio'],
            'end_date' => $validated['fin'],
            'scholarship_id' => $beca->id
        ]);
        return ConvocatoriaResource::make($convocatoria);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $scholarshipCall = ScholarshipCall::find($id);
        if(!$scholarshipCall) {
            return response()->json(['message' => 'No se encontró la convocatoria'], 404);
        }
        return ConvocatoriaResource::make($scholarshipCall);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ScholarshipCall $scholarshipCall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScholarshipCall $scholarshipCall)
    {
        //
    }
}
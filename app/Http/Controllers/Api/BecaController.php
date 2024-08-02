<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;

use App\Http\Resources\BecaResource;
use App\Http\Requests\Beca\IndexRequest as BecaIndexRequest;
use App\Http\Requests\Beca\CreateRequest as BecaCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BecaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BecaIndexRequest $request)
    {
        $request->validated();
        
        $becas = Scholarship::when($request->nombre, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->nombre . '%');
        })->when($request->descripcion, function ($query) use ($request) {
            return $query->where('description', 'like', '%' . $request->descripcion . '%');
        })->get();

        return $becas->count() > 0 ? BecaResource::collection($becas) : response()->json(['message' => 'No se encontraron becas'], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BecaCreateRequest $request)
    {
        $validator = Validator::make($request->all(), BecaCreateRequest::rules(), BecaCreateRequest::messages());
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }else{
            $beca = Scholarship::create($request->all());
            return BecaResource::make($beca);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Scholarship $scholarship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Scholarship $scholarship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scholarship $scholarship)
    {
        //
    }
}
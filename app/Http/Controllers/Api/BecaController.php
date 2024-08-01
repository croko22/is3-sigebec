<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;

use App\Http\Resources\BecaResource;
use App\Http\Requests\Beca\IndexRequest as BecaIndexRequest;
use Illuminate\Http\Request;

class BecaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BecaIndexRequest $request)
    {
        $becas = Scholarship::all();
        if ($becas->count() > 0) {
            return BecaResource::collection($becas);
        }
        return response()->json(['message' => 'No se encontraron becas'], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
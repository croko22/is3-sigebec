<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;

use App\Http\Resources\BecaResource;
use App\Http\Requests\Beca\IndexRequest as BecaIndexRequest;
use App\Http\Requests\Beca\CreateRequest as BecaCreateRequest;
use App\Http\Requests\Beca\UpdateRequest as BecaUpdateRequest;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Sigebec API',
    description: 'API para el Sistema de Gestión de Becas',
)]
#[OA\PathItem(
    path: "/api/becas"
)]

class BecaController extends Controller
{
    #[OA\Get(
        path: "/api/becas",
        operationId: "getBecas",
        tags: ["Becas"],
        summary: "Listado de becas",
        description: "Obtiene un listado de becas",
        responses: [
            new OA\Response(response: 200, description: "Listado de becas")
        ]
    )]
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

    #[OA\Post(
        path: "/api/becas",
        operationId: "storeBeca",
        tags: ["Becas"],
        summary: "Crear una nueva beca",
        description: "Crea una nueva beca",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ["nombre", "descripcion"],
                    properties: [
                        new OA\Property(property: 'nombre', description: "User first name", type: "string"),
                        new OA\Property(property: 'descripcion', description: "User last name", type: "string"),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Beca creada"),
            new OA\Response(response: 400, description: "Error en la solicitud")
        ]
    )]
    public function store(BecaCreateRequest $request)
    {
        $validated = $request->validated();
        $beca = Scholarship::create([
            'name' => $validated['nombre'],
            'description' => $validated['descripcion']
        ]);
        return BecaResource::make($beca);


    }

    #[OA\Get(
        path: "/api/becas/{id}",
        operationId: "getBeca",
        tags: ["Becas"],
        summary: "Obtener una beca",
        description: "Obtiene una beca por ID",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Beca encontrada"),
            new OA\Response(response: 404, description: "Beca no encontrada")
        ]
    )]
    public function show($id)
    {
        $scholarship = Scholarship::find($id);
        if (!$scholarship) {
            return response()->json(['message' => 'No se encontró la beca'], 404);
        }
        return BecaResource::make($scholarship);
    }

    #[OA\Put(
        path: "/api/becas/{id}",
        operationId: "updateBeca",
        tags: ["Becas"],
        summary: "Actualizar una beca",
        description: "Actualiza una beca por ID",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ["nombre", "descripcion"],
                    properties: [
                        new OA\Property(property: 'nombre', description: "User first name", type: "string"),
                        new OA\Property(property: 'descripcion', description: "User last name", type: "string"),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Beca actualizada"),
            new OA\Response(response: 404, description: "Beca no encontrada")
        ]
    )]
    public function update(BecaUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $scholarship = Scholarship::find($id);
        if (!$scholarship) {
            return response()->json(['message' => 'No se encontró la beca'], 404);
        }
        $scholarship->update([
            'name' => $validated['nombre'] ?? $scholarship->name,
            'description' => $validated['descripcion'] ?? $scholarship->description
        ]);
        return BecaResource::make($scholarship);
    }

    #[OA\Delete(
        path: "/api/becas/{id}",
        operationId: "deleteBeca",
        tags: ["Becas"],
        summary: "Eliminar una beca",
        description: "Elimina una beca por ID",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 204, description: "Beca eliminada"),
            new OA\Response(response: 404, description: "Beca no encontrada")
        ]
    )]
    public function destroy($id)
    {
        $beca = Scholarship::find($id);
        if (!$beca) {
            return response()->json(['message' => 'No se encontró la beca'], 404);
        }
        $beca->delete();
        return response()->json(['message' => 'Beca eliminada correctamente'], 200);
    }
}
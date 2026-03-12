<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTreatmentRequest;
use OpenApi\Attributes as OA;

#[OA\Info(title: "Treatment API", version: "1.0.0", description: "Micro-service for managing rare disease treatments")]
#[OA\Server(url: "http://localhost:8006", description: "Serveur Local")]


class TreatmentController extends Controller
{
    #[OA\Get(
        path: "/api/treatments",
        summary: "List all treatments with pagination",
        tags: ["Treatments"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Paginated list of treatments",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "current_page", type: "integer", example: 1),
                        new OA\Property(property: "data", type: "array", items: new OA\Items(
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "patient_id", type: "integer", example: 1),
                                new OA\Property(property: "medication_name", type: "string", example: "Aspirin"),
                                new OA\Property(property: "dosage", type: "string", example: "500mg"),
                                new OA\Property(property: "frequency", type: "string", example: "3x/day"),
                                new OA\Property(property: "start_date", type: "string", format: "date", example: "2026-03-11")
                            ]
                        )),
                        new OA\Property(property: "total", type: "integer", example: 50),
                        new OA\Property(property: "per_page", type: "integer", example: 15),
                        new OA\Property(property: "last_page", type: "integer", example: 4)
                    ]
                )
            )
        ]
    )]
    public function index()
    {
        return response()->json(Treatment::paginate(10), 200);
    }
    #[OA\Post(
        path: "/api/treatments",
        summary: "Create a new treatment",
        tags: ["Treatments"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["patient_id", "medication_name", "dosage", "frequency", "start_date"],
                properties: [
                    new OA\Property(property: "patient_id", type: "integer", example: 1),
                    new OA\Property(property: "medication_name", type: "string", example: "Aspirin"),
                    new OA\Property(property: "dosage", type: "string", example: "500mg"),
                    new OA\Property(property: "frequency", type: "string", example: "3x/day"),
                    new OA\Property(property: "start_date", type: "string", format: "date", example: "2026-03-11")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Treatment created successfully"),
            new OA\Response(response: 422, description: "Validation error")
        ]
    )]
    public function store(Request $request)
    {
        $validateData = StoreTreatmentRequest::validate($request);

        $treatment = Treatment::create($validateData);

        return response()->json($treatment, 201);
    }
    #[OA\Get(
        path: "/api/treatments/{id}",
        summary: "Get a specific treatment",
        tags: ["Treatments"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID of the treatment",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Treatment found"),
            new OA\Response(response: 404, description: "Treatment not found")
        ]
    )]
    public function show(int $id)
    {
        $treatment = Treatment::find($id);
        if (!$treatment) {
            return response()->json(['message' => 'Treatment not found'], 404);
        }
        return response()->json($treatment, 200);
    }
    #[OA\Put(
        path: "/api/treatments/{id}",
        summary: "Update a treatment",
        tags: ["Treatments"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "patient_id", type: "integer", example: 1),
                    new OA\Property(property: "medication_name", type: "string", example: "Aspirin"),
                    new OA\Property(property: "dosage", type: "string", example: "500mg"),
                    new OA\Property(property: "frequency", type: "string", example: "3x/day"),
                    new OA\Property(property: "start_date", type: "string", format: "date", example: "2026-03-11")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Treatment updated successfully"),
            new OA\Response(response: 404, description: "Treatment not found")
        ]
    )]
    public function update(Request $request, int $id)
    {
        $treatment = Treatment::find($id);
        if (!$treatment) {
            return response()->json(['message' => 'Treatment not found'], 404);
        }
        $validateData = StoreTreatmentRequest::validate($request);
        $treatment->update($validateData);
        return response()->json($treatment, 200);
    }
    #[OA\Delete(
        path: "/api/treatments/{id}",
        summary: "Delete a treatment",
        tags: ["Treatments"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Treatment deleted successfully"),
            new OA\Response(response: 404, description: "Treatment not found")
        ]
    )]
    public function destroy(int $id)
    {
        $treatment = Treatment::find($id);
        if (!$treatment) {
            return response()->json(['message' => 'Treatment not found'], 404);
        }
        $treatment->delete();
        return response()->json(['message' => 'Treatment deleted successfully']);
    }
}

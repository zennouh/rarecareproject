<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTreatmentRequest;

/**
 * @OA\Info(
 * title="RareCare Treatment API",
 * version="1.0.0",
 * description="Micro-service for managing rare disease treatments in Morocco"
 * )
 */
class TreatmentController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/treatments",
     * summary="List all treatments",
     * tags={"Treatments"},
     * @OA\Response(response="200", description="List retrieved successfully")
     * )
     */
    public function index()
    {
        return response()->json(Treatment::paginate(10), 200);
    }
    /**
     * @OA\Post(
     * path="/api/treatments",
     * summary="Create a new treatment",
     * tags={"Treatments"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"patient_id","medication_name","dosage","frequency","start_date"},
     * @OA\Property(property="patient_id", type="integer", example=1),
     * @OA\Property(property="medication_name", type="string", example="Aspirin"),
     * @OA\Property(property="dosage", type="string", example="500mg"),
     * @OA\Property(property="frequency", type="string", example="3x/day"),
     * @OA\Property(property="start_date", type="string", format="date", example="2026-03-11")
     * )
     * ),
     * @OA\Response(response="201", description="Treatment created successfully"),
     * @OA\Response(response="422", description="Validation error")
     * )
     */

    public function store(Request $request)
    {
        $validateData = StoreTreatmentRequest::validate($request);

        $treatment = Treatment::create($validateData);

        return response()->json($treatment, 201);
    }
    /**
     * @OA\Get(
     * path="/api/treatments/{id}",
     * summary="Get a specific treatment",
     * tags={"Treatments"},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response="200", description="Treatment found"),
     * @OA\Response(response="404", description="Treatment not found")
     * )
     */
    public function show(int $id)
    {
        $treatment = Treatment::find($id);
        if (!$treatment) {
            return response()->json(['message' => 'Treatment not found'], 404);
        }
        return response()->json($treatment, 200);
    }
    /**
     * @OA\Put(
     * path="/api/treatments/{id}",
     * summary="Update a treatment",
     * tags={"Treatments"},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="completed")
     * )
     * ),
     * @OA\Response(response="200", description="Treatment updated"),
     * @OA\Response(response="404", description="Treatment not found")
     * )
     */
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
    /**
     * @OA\Delete(
     * path="/api/treatments/{id}",
     * summary="Delete a treatment",
     * tags={"Treatments"},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response="200", description="Treatment deleted"),
     * @OA\Response(response="404", description="Treatment not found")
     * )
     */
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

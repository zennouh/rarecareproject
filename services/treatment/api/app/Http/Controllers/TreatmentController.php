<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTreatmentRequest;

class TreatmentController extends Controller
{
    public function index()
    {
        return response()->json(Treatment::paginate(10), 200);
    }

    public function store(Request $request)
    {
        $validateData = StoreTreatmentRequest::validate($request);

        $treatment = Treatment::create($validateData);

        return response()->json($treatment, 201);
    }
    public function show(int $id)
    {
        $treatment = Treatment::find($id);
        if (!$treatment) {
            return response()->json(['message' => 'Treatment not found'], 404);
        }
        return response()->json($treatment, 200);
    }
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

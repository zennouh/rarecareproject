<?php

namespace APP\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $record_medical = MedicalRecord::all();
        return $record_medical;
    }
    public function show($id)
    {
        $record_medical = MedicalRecord::find($id);
        return $record_medical;
    }
    public function create(Request $request)
    {
        $record_medical = MedicalRecord::create($request->all());
        return response()->json(['message' => $record_medical . 'Dossier Medical a etait creer avec succes :}', 200]);
    }
    public function update(Request $request, $id)
    {
        $record_medical = MedicalRecord::findOrFail($id);
        $record_medical->update($request->all());
        return response()->json(['message' => 'Le Dossier Medical : ' . $record_medical->name . ' a etait bien Modifier ', 200]);
    }
    public function destroy($id)
    {
        $record_medical = MedicalRecord::findOrFail($id);
        $record_medical->delete();
        return response()->json(['message' => 'Le dossier medicale' . $record_medical->name . 'a bien supprime 3iiiiich :µ', 200]);
    }
}

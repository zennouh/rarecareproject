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
        // dd($record_medical);
        if ($record_medical->isEmpty()) {
            return response()->json(['message' => 'maintenant il ya pas aucun dossier medical :/'], 404);
        } else {
            return response()->json($record_medical, 200);
        }
    }
    public function show($id)
    {
        $record_medical = MedicalRecord::find($id);
        return response()->json($record_medical, 200);
    }
    public function create(Request $request)
    {
        MedicalRecord::create($request->all());
        return response()->json(['message' =>  'Dossier Medical a etait creer avec succes :}'], 200);
    }
    public function update(Request $request, $id)
    {
        $record_medical = MedicalRecord::findOrFail($id);
        $record_medical->update($request->all());
        return response()->json(['message' => 'Le Dossier Medical : ' . $record_medical->name . ' a etait bien Modifier '], 200);
    }
    public function destroy($id)
    {
        $record_medical = MedicalRecord::findOrFail($id);
        $record_medical->delete();
        return response()->json(['message' => 'Le dossier medicale' . $record_medical->name . 'a bien supprime 3iiiiich :µ'], 200);
    }
}

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
            return response()->json(['message' => 'maintenant il ya pas aucun dossier medical :<'], 404);
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
        return response()->json(['message' => 'Le dossier medicale ' . $record_medical->name . ' a bien supprime 3iiiiich :µ'], 200);
    }
    public function generatePdf($id)
    {
        $record = MedicalRecord::findOrFail($id);

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . getenv('GROQ_API_KEY'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'    => 'llama-3.1-8b-instant',
            'messages' => [
                [
                    'role'    => 'user',
                    'content' => "Generate a professional medical summary:
                Name: {$record->name}
                Description: {$record->description}"
                ]
            ]
        ]);

        $summary = $response->json()['choices'][0]['message']['content'];

        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML("
        <h1>Medical Record Report</h1>
        <h2>Patient Information</h2>
        <p><strong>Name:</strong> {$record->name}</p>
        <p><strong>Description:</strong> {$record->description}</p>
        <p><strong>Date:</strong> {$record->created_at}</p>
        <h2>AI Generated Summary</h2>
        <p>{$summary}</p>
    ");

        $filename = 'medical_record_' . $id . '_' . time() . '.pdf';
        $path = storage_path('app/pdf/' . $filename);

        

        file_put_contents($path, $pdf->output());
        $record->update(['pdf_path' => 'app/pdf/' . $filename]);

        return response()->download($path);
    }
}

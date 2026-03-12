<?php

namespace App\Http\Controllers;
use App\Models\Treatment;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
   public function exportPdf($id)
{
    $traitement = Treatment::find($id);

    $name = $traitement->name;
    $description = $traitement->description;
    $pdf = Pdf::loadView('pdf.report', compact('name', 'description'));

    return $pdf->stream();
}
}
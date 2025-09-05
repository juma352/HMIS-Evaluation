<?php

namespace App\Http\Controllers;

use App\Models\VendorEvaluation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $vendorEvaluations = VendorEvaluation::with('user')->latest()->get();
        return view('reports.index', compact('vendorEvaluations'));
    }

    public function show(VendorEvaluation $vendorEvaluation)
    {
        return view('reports.show', compact('vendorEvaluation'));
    }

    public function downloadPdf(VendorEvaluation $vendorEvaluation)
    {
        $pdf = Pdf::loadView('reports.pdf', compact('vendorEvaluation'));
        return $pdf->download('evaluation-report-' . $vendorEvaluation->id . '.pdf');
    }
}

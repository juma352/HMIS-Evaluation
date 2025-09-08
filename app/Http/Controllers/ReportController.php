<?php

namespace App\Http\Controllers;

use App\Models\Evaluator;
use App\Models\Vendor;
use App\Models\VendorEvaluation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = VendorEvaluation::with('user');

        if ($request->filled('vendor')) {
            if (!Vendor::where('name', $request->vendor)->exists()) {
                return redirect()->route('reports.index')->with('error', 'Selected vendor not found.');
            }
            $query->where('vendor_name', $request->vendor);
        }

        if ($request->filled('evaluator')) {
            if (!Evaluator::where('name', $request->evaluator)->exists()) {
                return redirect()->route('reports.index')->with('error', 'Selected evaluator not found.');
            }
            $query->where('evaluator_name', $request->evaluator);
        }

        // Apply default form_type=A if none provided
        $formType = $request->input('form_type', 'A');
        $query->where('form_type', $formType);

        $vendorEvaluations = $query->orderBy('evaluator_name')->get()->groupBy('evaluator_name');
        $vendors = Vendor::pluck('name')->unique()->sort();
        $evaluators = Evaluator::pluck('name')->unique()->sort();
        $sectionsConfig = app(VendorEvaluationController::class)->getSectionsConfig($formType);

        return view('reports.index', compact('vendorEvaluations', 'vendors', 'evaluators', 'sectionsConfig', 'formType') + ['header' => 'Vendor Evaluation Reports']);
    }

    public function show(VendorEvaluation $vendorEvaluation)
    {
        $sectionsConfig = app(VendorEvaluationController::class)->getSectionsConfig($vendorEvaluation->form_type);
        return view('reports.show', compact('vendorEvaluation', 'sectionsConfig') + ['header' => 'Vendor Evaluation Details']);
    }

    public function updateCommitteeComment(Request $request, VendorEvaluation $vendorEvaluation)
    {
        $request->validate([
            'final_committee_comment' => 'nullable|string',
        ]);

        $vendorEvaluation->update([
            'final_committee_comment' => $request->final_committee_comment,
        ]);

        return redirect()->route('reports.show', $vendorEvaluation->id)->with('success', 'Committee comment updated.');
    }

    public function downloadPdf(VendorEvaluation $vendorEvaluation)
    {
        $sectionsConfig = app(VendorEvaluationController::class)->getSectionsConfig($vendorEvaluation->form_type);
        $pdf = Pdf::loadView('reports.pdf', compact('vendorEvaluation', 'sectionsConfig'));
        return $pdf->download('evaluation-report-' . $vendorEvaluation->id . '.pdf');
    }
}
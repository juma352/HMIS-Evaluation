<!DOCTYPE html>
<html>
<head>
    <title>Vendor Evaluation Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        h1 { font-size: 20px; text-align: center; margin-bottom: 20px; }
        h2 { font-size: 16px; color: #1a73e8; margin-bottom: 10px; }
        h3 { font-size: 14px; margin-bottom: 8px; }
        .section { margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .label { font-weight: bold; }
        p { margin: 5px 0; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f8f9fa; font-weight: bold; }
    </style>
</head>
<body>
    <h1>{{ $vendorEvaluation->getFormNameAttribute() }} Report</h1>

    <div class="section">
        <h2>Evaluation Details</h2>
        <p><span class="label">Vendor:</span> {{ $vendorEvaluation->vendor_name }}</p>
        <p><span class="label">Evaluator:</span> {{ $vendorEvaluation->evaluator_name }}</p>
        <p><span class="label">Date:</span> {{ $vendorEvaluation->eval_date ? $vendorEvaluation->eval_date->format('Y-m-d') : 'N/A' }}</p>
        <p><span class="label">Total Score:</span> {{ number_format($vendorEvaluation->total_score, 2) }}%</p>
    </div>

    @foreach (['section_a', 'section_b', 'section_c', 'section_d', 'section_e', 'section_f'] as $sectionKey)
        @if (isset($vendorEvaluation->$sectionKey) && is_array($vendorEvaluation->$sectionKey))
            <div class="section">
                <h3>{{ $sectionsConfig[$sectionKey]['title'] ?? ucfirst(str_replace('_', ' ', $sectionKey)) }}</h3>
                @if ($vendorEvaluation->form_type === 'A')
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Criterion</th>
                                <th>Score</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendorEvaluation->$sectionKey as $criterionKey => $criterionData)
                                <tr>
                                    <td>{{ $sectionsConfig[$sectionKey]['criteria'][$criterionKey]['title'] ?? ucfirst(str_replace('_', ' ', $criterionKey)) }}</td>
                                    <td>{{ $criterionData['score'] ?? 'N/A' }}</td>
                                    <td>{{ $criterionData['comment'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p><span class="label">Category Score:</span> {{ number_format($vendorEvaluation->{'section' . strtoupper(substr($sectionKey, -1)) . 'Avg'}() * 20, 2) }}%</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Rating</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendorEvaluation->$sectionKey['ratings'] ?? [] as $ratingKey => $data)
                                <tr>
                                    <td>{{ $sectionsConfig[$sectionKey]['criteria']['rating_' . $ratingKey]['title'] ?? 'Rating ' . $ratingKey }}</td>
                                    <td>{{ $data['score'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p><span class="label">Section Comments:</span> {{ $vendorEvaluation->$sectionKey['comments'] ?? 'N/A' }}</p>
                    <p><span class="label">Category Score:</span> {{ number_format($vendorEvaluation->{'section' . strtoupper(substr($sectionKey, -1)) . 'Avg'}() * 20, 2) }}%</p>
                @endif
            </div>
        @endif
    @endforeach

    <div class="section">
        <h2>Summary & Recommendation</h2>
        <p><span class="label">Key Strengths:</span> {{ $vendorEvaluation->key_strengths ?? 'N/A' }}</p>
        @if ($vendorEvaluation->form_type === 'A')
            <p><span class="label">Areas for Improvement:</span> {{ $vendorEvaluation->areas_for_improvement ?? 'N/A' }}</p>
            <p><span class="label">Final Comments:</span> {{ $vendorEvaluation->final_comments ?? 'N/A' }}</p>
        @else
            <p><span class="label">Key Risks:</span> {{ $vendorEvaluation->key_risks ?? 'N/A' }}</p>
        @endif
        <p><span class="label">Recommendation:</span> {{ $vendorEvaluation->recommendation ?? 'N/A' }}</p>
        <p><span class="label">Final Committee Comment:</span> {{ $vendorEvaluation->final_committee_comment ?? 'N/A' }}</p>
    </div>
</body>
</html>
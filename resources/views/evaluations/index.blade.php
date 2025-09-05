<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen p-4">
    <div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Evaluation Results</h2>

        @foreach ($evaluations as $evaluation)
            <div class="mb-8 border-b pb-8">
                <h3 class="text-xl font-semibold mb-4">Vendor: {{ $evaluation->vendor_name }}</h3>
                <p><strong>Evaluator:</strong> {{ $evaluation->evaluator_name }}</p>
                <p><strong>Form Type:</strong> {{ $evaluation->form_type === 'A' ? 'HMIS Vendor Evaluation' : 'Refactoring Evaluation' }}</p>
                <p><strong>Date:</strong> {{ $evaluation->created_at->format('Y-m-d') }}</p>
                <p><strong>Total Score:</strong> {{ number_format($evaluation->total_score, 2) }}%</p>

                @if ($evaluation->form_type === 'A')
                    <div class="mt-4">
                        <h4 class="font-semibold">Category Scores:</h4>
                        <ul>
                            <li>Functional Capabilities & Workflow Alignment: {{ collect($evaluation->section_a)->avg('score') * 20 }}%</li>
                            <li>Technical Architecture & Scalability: {{ collect($evaluation->section_b)->avg('score') * 20 }}%</li>
                            <li>Integration & Interoperability: {{ collect($evaluation->section_c)->avg('score') * 20 }}%</li>
                            <li>Vendor Stability, Support, & Partnership: {{ collect($evaluation->section_d)->avg('score') * 20 }}%</li>
                            <li>Security & Compliance: {{ collect($evaluation->section_e)->avg('score') * 20 }}%</li>
                            <li>Total Cost of Ownership (TCO): {{ collect($evaluation->section_f)->avg('score') * 20 }}%</li>
                        </ul>
                    </div>
                @else
                    <div class="mt-4">
                        <h4 class="font-semibold">Evaluation Details:</h4>
                        @php
                            $sections = ['section_a', 'section_b', 'section_c', 'section_d', 'section_e', 'section_f'];
                        @endphp
                        @foreach ($sections as $section)
                            @if (is_array($evaluation->$section))
                                @foreach ($evaluation->$section as $key => $value)
                                    <p><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> Score: {{ $value['score'] ?? 'N/A' }}, Comment: {{ $value['comment'] ?? '' }}</p>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                @endif

                <div class="mt-4">
                    <h4 class="font-semibold">Summary & Recommendation:</h4>
                    <p><strong>Key Strengths:</strong> {{ $evaluation->key_strengths }}</p>
                    <p><strong>Key Risks/Concerns:</strong> {{ $evaluation->key_risks }}</p>
                    <p><strong>Final Recommendation:</strong> {{ $evaluation->recommendation }}</p>
                    <p><strong>Next Steps:</strong> {{ $evaluation->next_steps }}</p>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
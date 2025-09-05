<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen p-4">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Evaluation Details</h2>

        <div class="mb-8 border-b pb-8">
            <h3 class="text-xl font-semibold mb-4">Vendor: {{ $evaluation->vendor_name }}</h3>
            <p><strong>Evaluator:</strong> {{ $evaluation->evaluator_name }}</p>
            <p><strong>Form Type:</strong> {{ $evaluation->form_type === 'A' ? 'HMIS Vendor Evaluation' : 'Custom Development Evaluation' }}</p>
            <p><strong>Date:</strong> 
                @if ($evaluation->form_type === 'A')
                    {{ $evaluation->evaluation_date ? $evaluation->evaluation_date->format('Y-m-d') : 'N/A' }}
                @else
                    {{ $evaluation->evaluation_date ? $evaluation->evaluation_date->format('Y-m-d') : 'N/A' }}
                @endif
            </p>
            <p><strong>Total Score:</strong> {{ number_format($evaluation->total_score, 2) }}%</p>

            @if ($evaluation->form_type === 'A')
                <div class="mt-4">
                    <h4 class="font-semibold">Category Scores:</h4>
                    <ul>
                        @foreach (['section_a', 'section_b', 'section_c', 'section_d', 'section_e', 'section_f'] as $sectionKey)
                            @if (isset($evaluation->$sectionKey) && is_array($evaluation->$sectionKey))
                                @php
                                    $scores = collect($evaluation->$sectionKey)->pluck('score')->filter();
                                    $averageScore = $scores->isNotEmpty() ? $scores->avg() : 0;
                                    // Calculate the weighted contribution of this section to the total score
                                    $sectionWeight = (float)str_replace('%', '', $sectionsConfig[$sectionKey]['weight']) / 100;
                                    $weightedContribution = ($averageScore * $sectionWeight) * 20; // Scale to 100
                                @endphp
                                <li>{{ $sectionsConfig[$sectionKey]['title'] ?? ucfirst(str_replace('_', ' ', $sectionKey)) }}: {{ number_format($weightedContribution, 2) }}%</li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="mt-4">
                    <h4 class="font-semibold">Detailed Section Breakdown:</h4>
                    @foreach (['section_a', 'section_b', 'section_c', 'section_d', 'section_e', 'section_f'] as $sectionKey)
                        @if (isset($evaluation->$sectionKey) && is_array($evaluation->$sectionKey))
                            <div class="mb-4 p-3 border rounded-md bg-gray-50">
                                <h5 class="font-medium text-lg mb-2">{{ $sectionsConfig[$sectionKey]['title'] ?? ucfirst(str_replace('_', ' ', $sectionKey)) }}</h5>
                                @foreach ($evaluation->$sectionKey as $criterionKey => $criterionData)
                                    <p class="text-sm ml-2"><strong>{{ $sectionsConfig[$sectionKey]['criteria'][$criterionKey]['title'] ?? ucfirst(str_replace('_', ' ', $criterionKey)) }}:</strong> Score: {{ $criterionData['score'] ?? 'N/A' }}, Comment: {{ is_array($criterionData) && isset($criterionData['comment']) ? (is_string($criterionData['comment']) ? $criterionData['comment'] : json_encode($criterionData['comment'])) : '' }}</p>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="mt-4">
                    <h4 class="font-semibold">Summary & Recommendation:</h4>
                    <p><strong>Key Strengths:</strong> {{ is_array($evaluation->key_strengths) ? json_encode($evaluation->key_strengths) : $evaluation->key_strengths }}</p>
                    <p><strong>Areas for Improvement:</strong> {{ is_array($evaluation->areas_for_improvement) ? json_encode($evaluation->areas_for_improvement) : $evaluation->areas_for_improvement }}</p>
                    <p><strong>Final Recommendation:</strong> {{ is_array($evaluation->recommendation) ? json_encode($evaluation->recommendation) : $evaluation->recommendation }}</p>
                    <p><strong>Final Comments:</strong> {{ is_array($evaluation->final_comments) ? json_encode($evaluation->final_comments) : $evaluation->final_comments }}</p>
                </div>
            @else {{-- Form Type B --}}
                <div class="mt-4">
                    <h4 class="font-semibold">Evaluation Details:</h4>
                    <p><strong>Date:</strong> 
                @if($evaluation->evaluation_date)
                    {{ $evaluation->evaluation_date->format('Y-m-d') }}
                @else
                    N/A
                @endif
            </p>
                    @foreach (['section_a', 'section_b', 'section_c', 'section_d', 'section_e', 'section_f'] as $sectionKey)
                        @if (isset($evaluation->$sectionKey) && is_array($evaluation->$sectionKey))
                            <div class="mb-4 p-3 border rounded-md bg-gray-50">
                                <h5 class="font-medium text-lg mb-2">{{ ucfirst(str_replace('_', ' ', $sectionKey)) }} Details:</h5>
                                @foreach ($evaluation->$sectionKey as $key => $value)
                                    <p class="text-sm ml-2"><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> Score: {{ $value['score'] ?? 'N/A' }}, Comment: {{ is_array($value) && isset($value['comment']) ? (is_string($value['comment']) ? $value['comment'] : json_encode($value['comment'])) : '' }}</p>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="mt-4">
                    <h4 class="font-semibold">Summary & Recommendation:</h4>
                    <p><strong>Key Strengths:</strong> {{ is_array($evaluation->key_strengths) ? json_encode($evaluation->key_strengths) : $evaluation->key_strengths }}</p>
                    <p><strong>Key Risks:</strong> {{ is_array($evaluation->key_risks) ? json_encode($evaluation->key_risks) : $evaluation->key_risks }}</p>
                    <p><strong>Recommendation:</strong> {{ is_array($evaluation->recommendation) ? json_encode($evaluation->recommendation) : $evaluation->recommendation }}</p>
                </div>
            @endif
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
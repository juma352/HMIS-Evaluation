<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Vendor Evaluation Details</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <h2 class="text-2xl font-bold mb-6 text-gray-900 text-center">Evaluation Details</h2>

                    <!-- Overview -->
                    <div class="mb-8 border-b pb-6">
                        <h3 class="text-xl font-semibold mb-4 text-gray-900">Vendor: {{ $vendorEvaluation->vendor_name }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <p><strong>Evaluator:</strong> {{ $vendorEvaluation->evaluator_name }}</p>
                            <p><strong>Form Type:</strong> {{ $vendorEvaluation->getFormNameAttribute() }}</p>
                            <p><strong>Date:</strong> {{ $vendorEvaluation->meeting_date ? $vendorEvaluation->meeting_date->format('Y-m-d') : 'N/A' }}</p>
                            <p><strong>Total Score:</strong> {{ number_format($vendorEvaluation->total_score, 2) }}%</p>
                        </div>
                    </div>

                    <!-- Sections -->
                    @foreach (['section_a', 'section_b', 'section_c', 'section_d', 'section_e', 'section_f'] as $sectionKey)
                        @if (isset($vendorEvaluation->$sectionKey) && is_array($vendorEvaluation->$sectionKey))
                            <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                                <h4 class="font-semibold text-lg mb-3 text-gray-900">{{ $sectionsConfig[$sectionKey]['title'] ?? ucfirst(str_replace('_', ' ', $sectionKey)) }}</h4>
                                @if ($vendorEvaluation->form_type === 'A')
                                    @foreach ($vendorEvaluation->$sectionKey as $criterionKey => $criterionData)
                                        <div class="mb-2 ml-4">
                                            <p class="text-sm text-gray-700">
                                                <strong>{{ $sectionsConfig[$sectionKey]['criteria'][$criterionKey]['title'] ?? ucfirst(str_replace('_', ' ', $criterionKey)) }}:</strong>
                                                Score: {{ $criterionData['score'] ?? 'N/A' }},
                                                Comment: {{ $criterionData['comment'] ?? 'N/A' }}
                                            </p>
                                        </div>
                                    @endforeach
                                    @php
                                        $scores = collect($vendorEvaluation->$sectionKey)->pluck('score')->filter();
                                        $averageScore = $scores->isNotEmpty() ? $scores->avg() : 0;
                                        $sectionWeight = (float)str_replace('%', '', $sectionsConfig[$sectionKey]['weight']) / 100;
                                        $weightedContribution = ($averageScore * $sectionWeight) * 20;
                                    @endphp
                                    <p class="mt-3 font-semibold text-sm text-gray-900">Weighted Score: {{ number_format($weightedContribution, 2) }}%</p>
                                @else
                                    @foreach ($vendorEvaluation->$sectionKey['ratings'] ?? [] as $ratingKey => $data)
                                        <div class="mb-2 ml-4">
                                            <p class="text-sm text-gray-700">
                                                <strong>{{ $sectionsConfig[$sectionKey]['criteria']['rating_' . $ratingKey]['description'] ?? 'Rating ' . $ratingKey }}:</strong>
                                                Score: {{ $data['score'] ?? 'N/A' }}
                                            </p>
                                        </div>
                                    @endforeach
                                    <p class="mt-2 text-sm text-gray-700"><strong>Section Comments:</strong> {{ $vendorEvaluation->$sectionKey['comments'] ?? 'N/A' }}</p>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    <!-- Summary & Recommendation -->
                    <div class="mt-8 p-4 border rounded-lg bg-gray-50">
                        <h4 class="font-semibold text-lg mb-3 text-gray-900">Summary & Recommendation</h4>
                        <p class="text-sm text-gray-700"><strong>Key Strengths:</strong> {{ $vendorEvaluation->key_strengths ?? 'N/A' }}</p>
                        @if ($vendorEvaluation->form_type === 'A')
                            <p class="text-sm text-gray-700"><strong>Areas for Improvement:</strong> {{ $vendorEvaluation->areas_for_improvement ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-700"><strong>Final Comments:</strong> {{ $vendorEvaluation->final_comments ?? 'N/A' }}</p>
                        @else
                            <p class="text-sm text-gray-700"><strong>Key Risks:</strong> {{ $vendorEvaluation->key_risks ?? 'N/A' }}</p>
                        @endif
                        <p class="text-sm text-gray-700"><strong>Recommendation:</strong> {{ $vendorEvaluation->recommendation ?? 'N/A' }}</p>
                    </div>

                    <!-- Final Committee Comment -->
                    <div class="mt-8">
                        <h4 class="font-semibold text-lg mb-3 text-gray-900">Final Committee Comment</h4>
                        <form method="POST" action="{{ route('reports.updateCommitteeComment', $vendorEvaluation->id) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <textarea name="final_committee_comment" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" rows="4" placeholder="Enter committee comment">{{ $vendorEvaluation->final_committee_comment }}</textarea>
                            <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save Comment</button>
                        </form>
                    </div>

                    <!-- Navigation -->
                    <div class="mt-6 flex justify-center space-x-4">
                        <a href="{{ route('reports.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Back to Reports</a>
                        <a href="{{ route('reports.downloadPdf', $vendorEvaluation->id) }}" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
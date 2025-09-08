<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Vendor Evaluation Reports</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Filters -->
                    <form method="GET" class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label for="vendor" class="block text-sm font-medium text-gray-700">Filter by Vendor</label>
                            <select name="vendor" id="vendor" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Vendors</option>
                                @foreach($vendors as $vendor)
                                <option value="{{ $vendor }}" {{ request('vendor') === $vendor ? 'selected' : '' }}>{{ $vendor }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="evaluator" class="block text-sm font-medium text-gray-700">Filter by Evaluator</label>
                            <select name="evaluator" id="evaluator" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Evaluators</option>
                                @foreach($evaluators as $evaluator)
                                <option value="{{ $evaluator }}" {{ request('evaluator') === $evaluator ? 'selected' : '' }}>{{ $evaluator }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="form_type" class="block text-sm font-medium text-gray-700">Filter by Form Type</label>
                            <select name="form_type" id="form_type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="A" {{ $formType === 'A' ? 'selected' : '' }}>HMIS Vendor Evaluation (Form A)</option>
                                <option value="B" {{ $formType === 'B' ? 'selected' : '' }}>Refactoring Evaluation Form (Form B)</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Apply Filters</button>
                        </div>
                    </form>

                    <!-- Grouped Evaluations -->
                    @if ($vendorEvaluations->isEmpty())
                    <p class="text-center text-gray-500 py-6">No evaluations found for the selected filters.</p>
                    @else
                    @foreach($vendorEvaluations as $evaluatorName => $evaluations)
                    <h2 class="text-xl font-semibold mb-4 text-gray-900">Evaluator: {{ $evaluatorName }}</h2>
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-sm rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Form Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    @if ($formType === 'A')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $sectionsConfig['section_a']['title'] ?? 'Section A' }} (%)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $sectionsConfig['section_b']['title'] ?? 'Section B' }} (%)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $sectionsConfig['section_c']['title'] ?? 'Section C' }} (%)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $sectionsConfig['section_d']['title'] ?? 'Section D' }} (%)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $sectionsConfig['section_e']['title'] ?? 'Section E' }} (%)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $sectionsConfig['section_f']['title'] ?? 'Section F' }} (%)</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Score (%)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recommendation</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Final Committee Comment</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($evaluations as $evaluation)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->vendor_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->getFormNameAttribute() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->meeting_date ? $evaluation->meeting_date->format('Y-m-d') : 'N/A' }}</td>
                                    @if ($formType === 'A')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($evaluation->sectionAAvg() * 20, 2) }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($evaluation->sectionBAvg() * 20, 2) }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($evaluation->sectionCAvg() * 20, 2) }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($evaluation->sectionDAvg() * 20, 2) }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($evaluation->sectionEAvg() * 20, 2) }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($evaluation->sectionFAvg() * 20, 2) }}%</td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($evaluation->total_score, 2) }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->recommendation }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->final_committee_comment ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('reports.show', $evaluation->id) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                        <span class="mx-2">|</span>
                                        <a href="{{ route('reports.downloadPdf', $evaluation->id) }}" class="text-green-600 hover:text-green-900">Download PDF</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
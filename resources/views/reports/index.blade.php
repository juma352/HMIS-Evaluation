<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Vendor Evaluation Reports</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->role === 'admin')
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

                    <!-- Grouped Evaluations by Vendor -->
                    @if ($vendorEvaluations->isEmpty())
                    <p class="text-center text-gray-500 py-6">No evaluations found for the selected filters.</p>
                    @else
                    <div class="space-y-4">
                        @foreach($vendorEvaluations as $vendorName => $evaluations)
                        <div x-data="{ open: false }" class="bg-gray-50 rounded-lg shadow">
                            <div @click="open = !open" class="p-4 cursor-pointer flex justify-between items-center">
                                <h2 class="text-xl font-semibold text-gray-900">Vendor: {{ $vendorName }}</h2>
                                <svg x-show="!open" class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                <svg x-show="open" class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                            </div>
                            <div x-show="open" class="p-4 border-t border-gray-200">
                                <div class="overflow-x-auto mb-8">
                                    <table class="min-w-full divide-y divide-gray-200 bg-white shadow-sm rounded-lg">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluator</th>
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
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($evaluations as $evaluation)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->evaluator_name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->getFormNameAttribute() }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->evaluation_date ? $evaluation->evaluation_date->format('Y-m-d') : 'N/A' }}</td>
                                                @if ($formType === 'A')
                                                @php
                                                    $sectionKeys = ['section_a', 'section_b', 'section_c', 'section_d', 'section_e', 'section_f'];
                                                @endphp
                                                @foreach ($sectionKeys as $sectionKey)
                                                    @php
                                                        $scores = collect($evaluation->$sectionKey)->pluck('score')->filter();
                                                        $averageScore = $scores->isNotEmpty() ? $scores->avg() : 0;
                                                        $sectionWeight = (float)str_replace('%', '', $sectionsConfig[$sectionKey]['weight']) / 100;
                                                        $weightedContribution = ($averageScore * $sectionWeight) * 20;
                                                    @endphp
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($weightedContribution, 2) }}%</td>
                                                @endforeach
                                                @endif
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($evaluation->total_score, 2) }}%</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->recommendation }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('reports.show', $evaluation->id) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Final Comment Section -->
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold text-gray-800">Final Committee Comment</h3>
                                    <div class="mt-2 text-sm text-gray-600 bg-gray-100 p-4 rounded-md">
                                        @php
                                            $finalComment = $evaluations->pluck('final_committee_comment')->filter()->last();
                                        @endphp
                                        <p>
                                            {!! $finalComment ? nl2br(e($finalComment)) : 'No final comment yet.' !!}
                                        </p>
                                    </div>
                                    <form method="POST" action="{{ route('reports.updateVendorComment') }}" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="vendor_name" value="{{ $vendorName }}">
                                        <div>
                                            <label for="final_comment_{{ $loop->index }}" class="block text-sm font-medium text-gray-700">Add/Update Final Comment</label>
                                            <textarea name="final_comment" id="final_comment_{{ $loop->index }}" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $finalComment ?? '' }}</textarea>
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save Comment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-center text-red-500">You are not authorized to view this page.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
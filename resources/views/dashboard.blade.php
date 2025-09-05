<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Welcome, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-700">
                    This is your dashboard where you can initiate new evaluations and review past results.
                </p>
                @if (session('success'))
                    <div class="mt-4 bg-green-100 text-green-700 p-4 rounded-md" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <!-- Select Form Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Select an Evaluation Form</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('evaluations.show', 'A') }}" class="flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-8 shadow-md transition duration-150 ease-in-out">
                        HMIS Vendor Evaluation
                    </a>
                    <a href="{{ route('evaluations.show', 'B') }}" class="flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 md:py-4 md:text-lg md:px-8 shadow-md transition duration-150 ease-in-out">
                        Refactoring Evaluation
                    </a>
                </div>
            </div>

            <!-- Evaluation Results Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Your Evaluation Results</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Form Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluator</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recommendation</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach (\App\Models\VendorEvaluation::all() as $evaluation)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->form_type === 'A' ? 'HMIS Vendor' : 'Refactoring Evaluation' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->vendor_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->evaluator_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($evaluation->form_type === 'A')
                                            {{ $evaluation->evaluation_date ? $evaluation->evaluation_date->format('Y-m-d') : 'N/A' }}
                                        @else
                                            {{ $evaluation->meeting_date ? $evaluation->meeting_date->format('Y-m-d') : 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($evaluation->total_score, 2) }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->recommendation }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('evaluations.showResult', $evaluation->id) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (\App\Models\VendorEvaluation::count() === 0)
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No evaluations submitted yet.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            
        </div>
    </div>
</x-app-layout>
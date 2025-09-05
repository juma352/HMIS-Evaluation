<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Evaluation Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Vendor Evaluation Report</h3>

                    <div class="mb-4">
                        <strong>Vendor Name:</strong> {{ $vendorEvaluation->vendor_name }}
                    </div>

                    <div class="mb-4">
                        <strong>Form Type:</strong> {{ $vendorEvaluation->form_name }}
                    </div>

                    <div class="mb-4">
                        <strong>Evaluator:</strong> {{ $vendorEvaluation->user->name }}
                    </div>

                    <div class="mb-4">
                        <strong>Evaluation Date:</strong> {{ $vendorEvaluation->created_at->format('M d, Y') }}
                    </div>

                    <h4 class="text-md font-semibold mt-6 mb-2">Evaluation Details:</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Answer</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($vendorEvaluation->evaluation_data as $key => $value)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ is_array($value) || is_object($value) ? json_encode($value) : $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('reports.downloadPdf', $vendorEvaluation) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Download PDF
                        </a>
                        <button onclick="window.print()" class="ml-3 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                            Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

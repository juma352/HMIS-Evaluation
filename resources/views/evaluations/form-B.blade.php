<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Refactoring Evaluation Form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg" x-data="evaluationForm()">
                        <h2 class="text-2xl font-bold mb-6 text-center">Refactoring Evaluation Form</h2>

                        @if (session('success'))
                            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('evaluations.store') }}" method="POST" x-ref="form">
                            @csrf
                            <input type="hidden" name="form_type" value="B">
                            
                            <!-- Basic Information -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Vendor/Firm Name</label>
                                    <select name="vendor_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required x-ref="vendor_name" x-bind:class="{ 'border-red-500 ring-red-500': errors.vendor_name }">
                                        <option value="">Select a vendor</option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->name }}">{{ $vendor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Evaluator(s)</label>
                                    <input list="evaluators" name="evaluator_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="e.g., John Doe" required x-ref="evaluator_name" x-bind:class="{ 'border-red-500 ring-red-500': errors.evaluator_name }">
                                    <datalist id="evaluators">
                                        @foreach($evaluators as $evaluator)
                                            <option value="{{ $evaluator->name }}">
                                        @endforeach
                                    </datalist>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date of Meeting</label>
                                    <input type="date" name="meeting_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required x-ref="meeting_date" x-bind:class="{ 'border-red-500 ring-red-500': errors.meeting_date }">
                                </div>
                            </div>

                            <!-- Section A: Project Understanding -->
            <div class="mb-8" id="section_a">
                <button type="button" @click="toggleSection('a', $event)" 
                        class="flex items-center w-full text-xl font-semibold mb-4 bg-indigo-50 p-4 rounded-lg">
                    <span x-text="openSection === 'a' ? '-' : '+'" class="mr-2"></span>
                    A. Project Understanding & Domain Knowledge
                </button>
                
                <div x-show="openSection === 'a'" x-cloak class="space-y-4 p-4">
                    <p class="text-gray-600 mb-4">This section assesses the vendor's grasp of the project's unique context and challenges based on the HMIS Challenges Report.</p>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor demonstrated a clear understanding of the current system's technology debt (e.g., outdated .NET Framework, WebForms, jQuery).</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.a[1].score" 
                                        name="sections[a][ratings][1][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.a.ratings[1].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor accurately summarized the project's strategic goals (e.g., modernization, improved security, scalability).</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.a[2].score" 
                                        name="sections[a][ratings][2][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.a.ratings[2].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor showed strong expertise in relevant healthcare standards, including the migration from HL7 v2 to HL7 FHIR.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.a[3].score" 
                                        name="sections[a][ratings][3][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.a.ratings[3].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor recognized the unique operational challenges of a live hospital environment and the need to minimize disruption.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.a[4].score" 
                                        name="sections[a][ratings][4][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.a.ratings[4].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Comments -->
                    <div class="mt-6 bg-indigo-50 p-4 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section Comments</label>
                            <textarea name="sections[a][comments]" rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                x-ref="comments_a" 
                                x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.a.comments }"
                                placeholder="Add your observations and evidence for this section"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section B: Technical Methodology & Approach -->
            <div class="mb-8">
                <button type="button" @click="toggleSection('b', $event)" 
                        class="flex items-center w-full text-xl font-semibold mb-4 bg-indigo-50 p-4 rounded-lg">
                    <span x-text="openSection === 'b' ? '-' : '+'" class="mr-2"></span>
                    B. Technical Methodology & Approach
                </button>
                
                <div x-show="openSection === 'b'" x-cloak class="space-y-4 p-4">
                    <p class="text-gray-600 mb-4">This section evaluates the credibility and soundness of the vendor's proposed technical plan.</p>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor presented a clear, credible, and well-defined methodology for refactoring the application from ASP.NET WebForms to .NET Core/Blazor.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.b[1].score" 
                                        name="sections[b][ratings][1][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.b.ratings[1].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The proposed approach for decoupling business logic from forms and creating a modern, service-oriented architecture is sound.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.b[2].score" 
                                        name="sections[b][ratings][2][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.b.ratings[2].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor’s plan for the UI/UX redesign is convincing and aligns with our goal for a modern, maintainable user experience.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.b[3].score" 
                                        name="sections[b][ratings][3][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.b.ratings[3].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor has a clear strategy for a phased migration to minimize risk and downtime, as opposed to a "big bang" rewrite.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.b[4].score" 
                                        name="sections[b][ratings][4][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.b.ratings[4].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Comments -->
                    <div class="mt-6 bg-indigo-50 p-4 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section Comments</label>
                            <textarea name="sections[b][comments]" rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                x-ref="comments_b" 
                                x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.b.comments }"
                                placeholder="Add your observations and evidence for this section"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section C: Security & Compliance Strategy -->
            <div class="mb-8">
                <button type="button" @click="toggleSection('c', $event)" 
                        class="flex items-center w-full text-xl font-semibold mb-4 bg-indigo-50 p-4 rounded-lg">
                    <span x-text="openSection === 'c' ? '-' : '+'" class="mr-2"></span>
                    C. Security & Compliance Strategy
                </button>
                
                <div x-show="openSection === 'c'" x-cloak class="space-y-4 p-4">
                    <p class="text-gray-600 mb-4">This section assesses the vendor's ability to address the critical security flaws identified in the Security Audit.</p>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor provided a confident and specific plan to remediate the identified security vulnerabilities (SQL Injection, insecure deserialization, etc.).</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.c[1].score" 
                                        name="sections[c][ratings][1][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.c.ratings[1].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor’s approach to implementing parameterized queries to fix SQL injection is aligned with best practices.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.c[2].score" 
                                        name="sections[c][ratings][2][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.c.ratings[2].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor demonstrated a strong commitment to data security and privacy principles appropriate for sensitive patient data.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.c[3].score" 
                                        name="sections[c][ratings][3][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.c.ratings[3].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor’s plan for implementing Two-Factor Authentication (2FA) is clear and technically sound.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.c[4].score" 
                                        name="sections[c][ratings][4][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.c.ratings[4].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Comments -->
                    <div class="mt-6 bg-indigo-50 p-4 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section Comments</label>
                            <textarea name="sections[c][comments]" rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                x-ref="comments_c" 
                                x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.c.comments }"
                                placeholder="Add your observations and evidence for this section"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section D: Future-Proofing & Roadmap Alignment -->
            <div class="mb-8">
                <button type="button" @click="toggleSection('d', $event)" 
                        class="flex items-center w-full text-xl font-semibold mb-4 bg-indigo-50 p-4 rounded-lg">
                    <span x-text="openSection === 'd' ? '-' : '+'" class="mr-2"></span>
                    D. Future-Proofing & Roadmap Alignment
                </button>
                
                <div x-show="openSection === 'd'" x-cloak class="space-y-4 p-4">
                    <p class="text-gray-600 mb-4">This section evaluates if the vendor's solution will be scalable and support future hospital goals as per the Technology Roadmap.</p>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The proposed architecture appears scalable and capable of supporting future roadmap features (AI/ML, DICOM integration, Smart Documentation).</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.d[1].score" 
                                        name="sections[d][ratings][1][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.d.ratings[1].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor agrees that a modern, service-oriented foundation is a prerequisite for advanced capabilities like AI/ML.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.d[2].score" 
                                        name="sections[d][ratings][2][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.d.ratings[2].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor presented a viable approach for viewer-level imaging integration and interfacing with external PACS systems.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.d[3].score" 
                                        name="sections[d][ratings][3][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.d.ratings[3].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor has relevant ideas or experience in implementing "Smart Documentation" features (NLP, Voice-to-Text, etc.).</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.d[4].score" 
                                        name="sections[d][ratings][4][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.d.ratings[4].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Comments -->
                    <div class="mt-6 bg-indigo-50 p-4 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section Comments</label>
                            <textarea name="sections[d][comments]" rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                x-ref="comments_d" 
                                x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.d.comments }"
                                placeholder="Add your observations and evidence for this section"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section E: Project Management & Collaboration -->
            <div class="mb-8">
                <button type="button" @click="toggleSection('e', $event)" 
                        class="flex items-center w-full text-xl font-semibold mb-4 bg-indigo-50 p-4 rounded-lg">
                    <span x-text="openSection === 'e' ? '-' : '+'" class="mr-2"></span>
                    E. Project Management & Collaboration
                </button>
                
                <div x-show="openSection === 'e'" x-cloak class="space-y-4 p-4">
                    <p class="text-gray-600 mb-4">This section assesses the working relationship and process.</p>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor’s project management methodology (e.g., Agile/Scrum) is well-defined and suits our needs.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.e[1].score" 
                                        name="sections[e][ratings][1][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.e.ratings[1].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The plan for communication, stakeholder engagement, and progress reporting is transparent and frequent.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.e[2].score" 
                                        name="sections[e][ratings][2][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.e.ratings[2].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor has a clear plan for knowledge transfer to ensure our internal team can maintain the system post-launch.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.e[3].score" 
                                        name="sections[e][ratings][3][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.e.ratings[3].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor appears to be a collaborative partner rather than just a contractor.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.e[4].score" 
                                        name="sections[e][ratings][4][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.e.ratings[4].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Comments -->
                    <div class="mt-6 bg-indigo-50 p-4 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section Comments</label>
                            <textarea name="sections[e][comments]" rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                x-ref="comments_e" 
                                x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.e.comments }"
                                placeholder="Add your observations and evidence for this section"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section F: Cost & Commercials -->
            <div class="mb-8">
                <button type="button" @click="toggleSection('f', $event)" 
                        class="flex items-center w-full text-xl font-semibold mb-4 bg-indigo-50 p-4 rounded-lg">
                    <span x-text="openSection === 'f' ? '-' : '+'" class="mr-2"></span>
                    F. Cost & Commercials
                </button>
                
                <div x-show="openSection === 'f'" x-cloak class="space-y-4 p-4">
                    <p class="text-gray-600 mb-4">This section evaluates the financial aspects of the proposal.</p>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The vendor provided a clear, detailed, and transparent cost breakdown for the entire project.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.f[1].score" 
                                        name="sections[f][ratings][1][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.f.ratings[1].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The proposed Total Cost of Ownership (TCO), including licensing and initial investment, appears reasonable for the value offered.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.f[2].score" 
                                        name="sections[f][ratings][2][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.f.ratings[2].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The post-launch support and maintenance costs (Annual Maintenance Cost - AMC) are clearly defined and seem sustainable.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.f[3].score" 
                                        name="sections[f][ratings][3][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.f.ratings[3].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm rating-group">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-grow">
                                <p class="text-gray-800">The proposed timeline aligns with our expectation of approximately 18 months.</p>
                            </div>
                            <div class="flex-shrink-0">
                                <select x-model="ratings.f[4].score" 
                                        name="sections[f][ratings][4][score]"
                                        class="w-32 pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.f.ratings[4].score }">
                                    <option value="">Rating</option>
                                    <option value="N/A">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Comments -->
                    <div class="mt-6 bg-indigo-50 p-4 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section Comments</label>
                            <textarea name="sections[f][comments]" rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                x-ref="comments_f" 
                                x-bind:class="{ 'border-red-500 ring-red-500': errors.sections.f.comments }"
                                placeholder="Add your observations and evidence for this section"></textarea>
                        </div>
                    </div>
                </div>
            </div>

                            <div class="flex justify-end space-x-4 mt-6">
                                <button type="button" @click="submitForm()" 
                                        class="w-48 bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Submit Evaluation
                                </button>
                                <a href="{{ route('evaluations.show', 'B') }}" 
                                   class="w-48 bg-gray-200 text-gray-700 py-3 px-4 rounded-md hover:bg-gray-300 transition-colors flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    Submit new evaluation form
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function evaluationForm() {
            return {
                openSection: null,
                ratings: {
                    a: { 1: { score: '' }, 2: { score: '' }, 3: { score: '' }, 4: { score: '' } },
                    b: { 1: { score: '' }, 2: { score: '' }, 3: { score: '' }, 4: { score: '' } },
                    c: { 1: { score: '' }, 2: { score: '' }, 3: { score: '' }, 4: { score: '' } },
                    d: { 1: { score: '' }, 2: { score: '' }, 3: { score: '' }, 4: { score: '' } },
                    e: { 1: { score: '' }, 2: { score: '' }, 3: { score: '' }, 4: { score: '' } },
                    f: { 1: { score: '' }, 2: { score: '' }, 3: { score: '' }, 4: { score: '' } }
                },
                errors: {
                    vendor_name: false,
                    evaluator_name: false,
                    meeting_date: false,
                    sections: {
                        a: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                        b: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                        c: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                        d: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                        e: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                        f: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false }
                    },
                    key_strengths: false,
                    key_risks: false,
                    recommendation: false
                },
                toggleSection(section, event) {
                    const isOpening = this.openSection !== section;
                    this.openSection = isOpening ? section : null;

                    if (isOpening) {
                        this.$nextTick(() => {
                            event.currentTarget.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        });
                    }
                },
                submitForm() {
                    // Reset errors
                    this.errors = {
                        vendor_name: false,
                        evaluator_name: false,
                        meeting_date: false,
                        sections: {
                            a: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                            b: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                            c: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                            d: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                            e: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false },
                            f: { ratings: { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } }, comments: false }
                        },
                        key_strengths: false,
                        key_risks: false,
                        recommendation: false
                    };

                    let isValid = true;
                    let firstErrorEl = null;

                    // Validate basic info
                    if (!this.$refs.vendor_name.value) { this.errors.vendor_name = true; isValid = false; firstErrorEl = firstErrorEl || this.$refs.vendor_name; }
                    if (!this.$refs.evaluator_name.value) { this.errors.evaluator_name = true; isValid = false; firstErrorEl = firstErrorEl || this.$refs.evaluator_name; }
                    if (!this.$refs.meeting_date.value) { this.errors.meeting_date = true; isValid = false; firstErrorEl = firstErrorEl || this.$refs.meeting_date; }

                    // Validate ratings
                    for (const sectionKey in this.ratings) {
                        const sectionRatings = this.ratings[sectionKey];
                        const sectionErrorRatings = { 1: { score: false }, 2: { score: false }, 3: { score: false }, 4: { score: false } };
                        let sectionHasError = false;
                        for (let i = 1; i <= 4; i++) {
                            if (!sectionRatings[i].score) {
                                sectionErrorRatings[i].score = true;
                                sectionHasError = true;
                                isValid = false;
                            }
                        }
                        if (sectionHasError) {
                            this.errors.sections[sectionKey].ratings = sectionErrorRatings;
                            if (!firstErrorEl) {
                                const firstInvalidRating = this.$el.querySelector(`[name='sections[${sectionKey}][ratings][1][score]']`);
                                firstErrorEl = firstInvalidRating;
                                this.openSection = sectionKey;
                            }
                        }
                    }

                    // Validate comments
                    for (const sectionKey of ['a', 'b', 'c', 'd', 'e', 'f']) {
                        if (!this.$refs[`comments_${sectionKey}`].value) {
                            this.errors.sections[sectionKey].comments = true;
                            isValid = false;
                            if (!firstErrorEl) firstErrorEl = this.$refs[`comments_${sectionKey}`];
                        }
                    }

                    // Validate summary
                    if (!this.$refs.key_strengths.value) { this.errors.key_strengths = true; isValid = false; firstErrorEl = firstErrorEl || this.$refs.key_strengths; }
                    if (!this.$refs.key_risks.value) { this.errors.key_risks = true; isValid = false; firstErrorEl = firstErrorEl || this.$refs.key_risks; }
                    if (!this.$refs.recommendation.value) { this.errors.recommendation = true; isValid = false; firstErrorEl = firstErrorEl || this.$refs.recommendation; }

                    if (isValid) {
                        this.$refs.form.submit();
                    } else {
                        if (firstErrorEl) {
                            firstErrorEl.focus();
                            firstErrorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        alert('Please fill out all required fields.');
                    }
                }
            }
        }
    </script>
</x-app-layout>

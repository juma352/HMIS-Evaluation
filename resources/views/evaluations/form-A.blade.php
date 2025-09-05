<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('HMIS Vendor Evaluation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="max-w-7xl mx-auto px-4 py-8" x-data="evaluationForm()">
                        <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
                            <!-- Header -->
                            <div class="text-center mb-8">
                                <h1 class="text-3xl font-bold text-gray-900">HMIS Vendor Evaluation Form</h1>
                                <p class="text-gray-600 mt-2">Comprehensive assessment of HMIS vendor capabilities</p>
                            </div>

                            <!-- Alert Messages -->
                            @if (session('success'))
                                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('evaluations.store') }}" method="POST" class="space-y-8">
                                @csrf
                                <input type="hidden" name="form_type" value="A">

                                <!-- Basic Information -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div>
                                            <label for="vendor_name" class="block text-sm font-medium text-gray-700">Vendor Name</label>
                                            <select name="vendor_name" id="vendor_name"
                                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                   required>
                                                <option value="">Select a vendor</option>
                                                @foreach($vendors as $vendor)
                                                    <option value="{{ $vendor->name }}">{{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="evaluator_name" class="block text-sm font-medium text-gray-700">Evaluator Name</label>
                                            <input list="evaluators" name="evaluator_name" id="evaluator_name"
                                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="e.g., John Doe"
                                                   required>
                                            <datalist id="evaluators">
                                                @foreach($evaluators as $evaluator)
                                                    <option value="{{ $evaluator->name }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div>
                                            <label for="evaluation_date" class="block text-sm font-medium text-gray-700">Evaluation Date</label>
                                            <input type="date" name="evaluation_date" id="evaluation_date" 
                                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Evaluation Sections -->
                <template x-for="(section, sectionKey) in sections" :key="sectionKey">
                    <div class="bg-white rounded-lg shadow mb-6">
                        <button type="button" 
                                @click="toggleSection(sectionKey, $event)"
                                class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none"
                                :class="{'bg-indigo-50': openSection === sectionKey}">
                            <div>
                                <h3 class="text-lg font-semibold" x-text="section.title"></h3>
                                <p class="text-sm text-gray-500" x-text="`Weight: ${section.weight}`"></p>
                            </div>
                            <svg class="w-5 h-5 transform transition-transform duration-200" 
                                 :class="{'rotate-180': openSection === sectionKey}"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="openSection === sectionKey" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="p-6 border-t">
                            <div class="space-y-6">
                                <template x-for="(criterion, criterionKey) in section.criteria" :key="criterionKey">
                                    <div class="criteria-card bg-gray-50 p-4 rounded-lg">
                                        <h4 class="font-medium text-gray-900 mb-2" x-text="criterion.title"></h4>
                                        <p class="text-sm text-gray-600 mb-4" x-text="criterion.description"></p>
                                        
                                        <!-- Scoring -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Score</label>
                                                <select x-model="scores[sectionKey][criterionKey]"
                                                        :name="`scores[${sectionKey}][${criterionKey}]`"
                                                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option value="">Select Score</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Comments</label>
                                                <textarea x-model="comments[sectionKey][criterionKey]"
                                                          :name="`comments[${sectionKey}][${criterionKey}]`"
                                                          rows="3"
                                                          class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                          placeholder="Enter your observations"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- Section Summary -->
                                <div class="mt-6 p-4 bg-indigo-50 rounded-lg">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium">Section Average:</span>
                                        <span class="text-lg font-semibold" x-text="calculateSectionAverage(sectionKey)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Final Score -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Overall Evaluation</h2>
                    
                    <!-- Section Scores Summary -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2">Section Scores (Average 1-5 Scale)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <template x-for="(section, sectionKey) in sections" :key="sectionKey">
                                <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                                    <span class="font-medium" x-text="section.title"></span>
                                    <span class="text-lg font-semibold" x-text="calculateSectionAverage(sectionKey).toFixed(2)"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="bg-white rounded-lg p-4 shadow">
                                <h3 class="text-lg font-medium mb-2">Final Score</h3>
                                <p class="text-3xl font-bold text-indigo-600" x-text="calculateTotalScore() + '%'"></p>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white rounded-lg p-4 shadow">
                                <h3 class="text-lg font-medium mb-2">Key Strengths</h3>
                                <textarea name="key_strengths" 
                                          class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                          rows="4"
                                          placeholder="Highlight the vendor's key strengths"></textarea>
                            </div>
                        </div> 
                        <div>
                            <div class="bg-white rounded-lg p-4 shadow">
                                <h3 class="text-lg font-medium mb-2">Key Risks/Concerns</h3>
                                <textarea name="areas_for_improvement" 
                                          class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                          rows="4"
                                          placeholder="Identify areas where the vendor can improve"></textarea>
                            </div>
                        </div>
                        <div>
                            <div class="bg-white rounded-lg p-4 shadow">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Final Recommendation</label>
                            <select name="recommendation" 
                                    class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                <option value="">Select Recommendation</option>
                                <option value="highly_recommended">Highly Recommended</option>
                                <option value="recommended">Recommended</option>
                                <option value="recommended_with_reservations">Recommended with Reservations</option>
                                <option value="not_recommended">Not Recommended</option>
                            </select>
                        </div>
                        
                </div>
                <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Next Steps</label>
                            <textarea name="final_comments" 
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                      rows="4"
                                      placeholder="Any additional comments regarding the evaluation"></textarea>
                    </div>
                </div>
            </div>

                                <!-- Submit Buttons -->
                                <div class="flex justify-end space-x-4 mt-6">
                                    <button type="submit" 
                                            class="w-48 bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Submit Evaluation
                                    </button>
                                    <a href="{{ route('evaluations.show', 'A') }}" 
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
    </div>
    <script>
        function evaluationForm() {
            return {
                openSection: 'section_a',
                scores: {},
                comments: {},
                sections: @json($sections),
                errors: {},
                toggleSection(sectionKey, event) {
                    const isOpening = this.openSection !== sectionKey;
                    this.openSection = isOpening ? sectionKey : null;

                    if (isOpening) {
                        this.$nextTick(() => {
                            if (event && event.currentTarget) {
                                event.currentTarget.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        });
                    }
                },
                calculateSectionAverage(sectionKey) {
                    if (!this.scores[sectionKey]) return 0; // Return 0 for calculation if no scores
                    const scores = Object.values(this.scores[sectionKey]).filter(score => score !== '');
                    if (scores.length === 0) return 0; // Return 0 for calculation if no scores
                    const avg = scores.reduce((sum, score) => sum + parseFloat(score), 0) / scores.length;
                    return avg; // Return as number
                },
                calculateTotalScore() {
                    let totalWeightedScore = 0;
                    let totalWeight = 0;

                    for (const sectionKey in this.sections) {
                        const section = this.sections[sectionKey];
                        const sectionAverage = this.calculateSectionAverage(sectionKey); // This is 1-5 scale
                        const sectionWeight = parseFloat(section.weight); // Get weight from sections data

                        if (sectionAverage > 0) { // Only include sections that have been scored
                            // Normalize 1-5 score to 0-100 percentage, then apply weight
                            const normalizedScore = ((sectionAverage - 1) / 4) * 100;
                            totalWeightedScore += normalizedScore * (sectionWeight / 100); // Weight is already a percentage, convert to decimal
                            totalWeight += sectionWeight;
                        }
                    }
                    
                    // If totalWeight is 0, return 0 to avoid division by zero
                    if (totalWeight === 0) return '0.00';

                    // The totalWeightedScore is already out of 100, so no further division by totalWeight is needed
                    // if the weights sum up to 100. If they don't, then we need to divide by totalWeight / 100
                    // Assuming weights sum to 100, totalWeightedScore is the final percentage.
                    return totalWeightedScore.toFixed(2);
                },
                init() {
                    // Initialize scores and comments objects
                    Object.keys(this.sections).forEach(sectionKey => {
                        this.scores[sectionKey] = {};
                        this.comments[sectionKey] = {};
                        this.errors[sectionKey] = {};
                        Object.keys(this.sections[sectionKey].criteria).forEach(criterionKey => {
                            this.scores[sectionKey][criterionKey] = '';
                            this.comments[sectionKey][criterionKey] = '';
                            this.errors[sectionKey][criterionKey] = false;
                        });
                    });
                },
                submitForm(event) {
                    let isValid = true;
                    let firstErrorEl = null;

                    // Reset errors
                    this.errors = {};
                     Object.keys(this.sections).forEach(sectionKey => {
                        this.errors[sectionKey] = {};
                        Object.keys(this.sections[sectionKey].criteria).forEach(criterionKey => {
                            this.errors[sectionKey][criterionKey] = false;
                        });
                    });

                    // Basic info
                    if (!document.querySelector('[name=vendor_name]').value) {
                        document.querySelector('[name=vendor_name]').classList.add('border-red-500');
                        isValid = false;
                        if(!firstErrorEl) firstErrorEl = document.querySelector('[name=vendor_name]');
                    } else {
                        document.querySelector('[name=vendor_name]').classList.remove('border-red-500');
                    }
                    if (!document.querySelector('[name=evaluator_name]').value) {
                        document.querySelector('[name=evaluator_name]').classList.add('border-red-500');
                        isValid = false;
                        if(!firstErrorEl) firstErrorEl = document.querySelector('[name=evaluator_name]');
                    } else {
                         document.querySelector('[name=evaluator_name]').classList.remove('border-red-500');
                    }
                    if (!document.querySelector('[name=evaluation_date]').value) {
                        document.querySelector('[name=evaluation_date]').classList.add('border-red-500');
                        isValid = false;
                        if(!firstErrorEl) firstErrorEl = document.querySelector('[name=evaluation_date]');
                    } else {
                        document.querySelector('[name=evaluation_date]').classList.remove('border-red-500');
                    }

                    // Scores
                    for (const sectionKey in this.sections) {
                        for (const criterionKey in this.sections[sectionKey].criteria) {
                            if (this.scores[sectionKey][criterionKey] === '') {
                                this.errors[sectionKey][criterionKey] = true;
                                isValid = false;
                                const el = this.$el.querySelector(`[name='scores[${sectionKey}][${criterionKey}]']`);
                                if (el) {
                                    el.classList.add('border-red-500');
                                    if (!firstErrorEl) {
                                        firstErrorEl = el;
                                        this.openSection = sectionKey;
                                    }
                                }
                            } else {
                                this.errors[sectionKey][criterionKey] = false;
                                const el = this.$el.querySelector(`[name='scores[${sectionKey}][${criterionKey}]']`);
                                if (el) {
                                    el.classList.remove('border-red-500');
                                }
                            }
                        }
                    }
                    
                    // Summary
                    if (!document.querySelector('[name=key_strengths]').value) {
                        document.querySelector('[name=key_strengths]').classList.add('border-red-500');
                        isValid = false;
                        if(!firstErrorEl) firstErrorEl = document.querySelector('[name=key_strengths]');
                    } else {
                        document.querySelector('[name=key_strengths]').classList.remove('border-red-500');
                    }
                    if (!document.querySelector('[name=areas_for_improvement]').value) {
                        document.querySelector('[name=areas_for_improvement]').classList.add('border-red-500');
                        isValid = false;
                        if(!firstErrorEl) firstErrorEl = document.querySelector('[name=areas_for_improvement]');
                    } else {
                        document.querySelector('[name=areas_for_improvement]').classList.remove('border-red-500');
                    }
                    if (!document.querySelector('[name=recommendation]').value) {
                        document.querySelector('[name=recommendation]').classList.add('border-red-500');
                        isValid = false;
                        if(!firstErrorEl) firstErrorEl = document.querySelector('[name=recommendation]');
                    } else {
                        document.querySelector('[name=recommendation]').classList.remove('border-red-500');
                    }


                    if (!isValid) {
                        event.preventDefault();
                        if (firstErrorEl) {
                            firstErrorEl.focus();
                            firstErrorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                }
            }
        }
    </script>
</x-app-layout>
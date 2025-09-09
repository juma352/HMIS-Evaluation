<?php

namespace App\Http\Controllers;

use App\Models\Evaluator;
use App\Models\Vendor;
use App\Models\VendorEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorEvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $evaluations = VendorEvaluation::all();
        return view('evaluations.index', compact('evaluations'));
    }

    public function show($type)
    {
        $vendors = Vendor::all();
        $evaluators = Evaluator::all();
        $sections = $this->getSectionsConfig($type);

        if ($type === 'A') {
            return view('evaluations.form-A', compact('type', 'sections', 'vendors', 'evaluators'));
        } elseif ($type === 'B') {
            return view('evaluations.form-B', compact('type', 'vendors', 'evaluators'));
        } else {
            abort(404);
        }
    }

    public function getSectionsConfig($type)
    {
        if ($type === 'A') {
            return [
                'section_a' => [
                    'title' => 'Functional Capabilities & Workflow Alignment',
                    'weight' => '25%',
                    'criteria' => [
                        'criterion_1' => [
                            'title' => 'Outpatient/Inpatient Workflow Efficiency',
                            'description' => 'Does it streamline patient journeys (registration to discharge), track TAT at key points, and support satellite centers (Naivasha, Marira, Nairobi)?'
                        ],
                        'criterion_2' => [
                            'title' => 'Clinical Documentation & Modules',
                            'description' => 'Covers SOAP templates, ICD-11 coding, mental health, emergency, theater ops? Includes RIS/LIS, pathology, pharmacy/inventory?'
                        ],
                        'criterion_3' => [
                            'title' => 'Backend Modules Depth',
                            'description' => 'Handles HR, estate management, supply chain (prequalification, requisitions, stock takes), POS?'
                        ],
                        'criterion_4' => [
                            'title' => 'Reporting & Analytics',
                            'description' => 'Real-time dashboards, customizable reports (e.g., MOH tools for TB/HIV), BI for data-driven decisions?'
                        ],
                        'criterion_5' => [
                            'title' => 'AI & Advanced Features',
                            'description' => 'Integrates AI for clinical support, predictive analytics, automation (e.g., scheduling, diagnostics)?'
                        ]
                    ]
                ],
                'section_b' => [
                    'title' => 'Technical Architecture & Scalability',
                    'weight' => '20%',
                    'criteria' => [
                        'criterion_1' => [
                            'title' => 'Technology Stack Modernity',
                            'description' => 'Uses modern frameworks (e.g., .NET Core, SPA) vs. outdated (e.g., WebForms, MPA)? Web-based, responsive for mobile/tablets?'
                        ],
                        'criterion_2' => [
                            'title' => 'Performance & Stability',
                            'description' => 'Response time <5s under load (>1000 users)? Demonstrated uptime/slowness mitigation?'
                        ],
                        'criterion_3' => [
                            'title' => 'Scalability & Future-Readiness',
                            'description' => 'Modular design for growth; supports cloud/on-premise; AI/mobile access readiness?'
                        ],
                        'criterion_4' => [
                            'title' => 'User Experience & Usability',
                            'description' => 'Intuitive UI, minimal training curve; accessibility (WCAG-compliant)?'
                        ]
                    ]
                ],
                'section_c' => [
                    'title' => 'Integration & Interoperability',
                    'weight' => '20%',
                    'criteria' => [
                        'criterion_1' => [
                            'title' => 'Data Migration Plan',
                            'description' => 'Seamless, secure migration from SmartCare; ensures data integrity/validation?'
                        ],
                        'criterion_2' => [
                            'title' => 'Financial Integrations',
                            'description' => 'M-Pesa API (real-time payments), insurance portals (e-claims, pre-auth), SHA/DHA compliance?'
                        ],
                        'criterion_3' => [
                            'title' => 'Third-Party & Equipment Integration',
                            'description' => 'Lab/radiology devices, KRA/UHC, external ERPs; supports HL7/FHIR standards?'
                        ],
                        'criterion_4' => [
                            'title' => 'API & Documentation',
                            'description' => 'Robust APIs for custom integrations; offline sync capabilities?'
                        ]
                    ]
                ],
                'section_d' => [
                    'title' => 'Vendor Stability, Support, & Partnership',
                    'weight' => '15%',
                    'criteria' => [
                        'criterion_1' => [
                            'title' => 'Track Record & Experience',
                            'description' => '>5 years; successful Kenyan implementations (e.g., similar faith-based hospitals)? References verifiable?'
                        ],
                        'criterion_2' => [
                            'title' => 'Support Model & SLA',
                            'description' => 'Local presence, <24h response (vs. 48h); post-go-live support (e.g., 3-6 months free)?'
                        ],
                        'criterion_3' => [
                            'title' => 'Implementation Methodology',
                            'description' => 'Agile/Scrum plan; phased timeline (~18 months); knowledge transfer to internal team?'
                        ],
                        'criterion_4' => [
                            'title' => 'Partnership Approach',
                            'description' => 'Collaborative; source code access to avoid lock-in; long-term upgrades commitment?'
                        ]
                    ]
                ],
                'section_e' => [
                    'title' => 'Security & Compliance',
                    'weight' => '10%',
                    'criteria' => [
                        'criterion_1' => [
                            'title' => 'Core Security Features',
                            'description' => 'Protects against SQL injection, deserialization; RBAC, audit trails?'
                        ],
                        'criterion_2' => [
                            'title' => 'Data Protection',
                            'description' => 'Encryption (at rest/transit); HIPAA/GDPR equivalent; ODPC registration as data processor?'
                        ],
                        'criterion_3' => [
                            'title' => 'Regulatory Compliance',
                            'description' => 'MOH standards, ISO 15189:2022, Digital Health Act 2023; breach notification?'
                        ]
                    ]
                ],
                'section_f' => [
                    'title' => 'Total Cost of Ownership (TCO)',
                    'weight' => '10%',
                    'criteria' => [
                        'criterion_1' => [
                            'title' => 'Cost Breakdown Transparency',
                            'description' => 'Detailed: One-time (implementation, migration, customization), annual (AMC, licenses)? VAT inclusive?'
                        ],
                        'criterion_2' => [
                            'title' => 'Reasonableness & Sustainability',
                            'description' => 'TCO over 3-5 years reasonable; includes training/integrations? No hidden fees?'
                        ],
                        'criterion_3' => [
                            'title' => 'Payment & Timeline Alignment',
                            'description' => 'Milestone-based terms (e.g., 30 days post-sign-off); fits 18-month rollout?'
                        ]
                    ]
                ]
            ];
        } elseif ($type === 'B') {
            return [
                'section_a' => [
                    'title' => 'Project Understanding & Domain Knowledge',
                    'weight' => '20%',
                    'criteria' => [
                        'rating_1' => ['description' => 'The vendor demonstrated a clear understanding of the current system’s technology debt (e.g., outdated .NET Framework, WebForms, jQuery).'],
                        'rating_2' => ['description' => 'The vendor accurately summarized the project’s strategic goals (e.g., modernization, improved security, scalability).'],
                        'rating_3' => ['description' => 'The vendor showed strong expertise in relevant healthcare standards, including the migration from HL7 v2 to HL7 FHIR.'],
                        'rating_4' => ['description' => 'The vendor recognized the unique operational challenges of a live hospital environment and the need to minimize disruption.']
                    ]
                ],
                'section_b' => [
                    'title' => 'Technical Methodology & Approach',
                    'weight' => '20%',
                    'criteria' => [
                        'rating_1' => ['description' => 'The vendor presented a clear, credible, and well-defined methodology for refactoring the application from ASP.NET WebForms to .NET Core/Blazor.'],
                        'rating_2' => ['description' => 'The proposed approach for decoupling business logic from forms and creating a modern, service-oriented architecture is sound.'],
                        'rating_3' => ['description' => 'The vendor’s plan for the UI/UX redesign is convincing and aligns with our goal for a modern, maintainable user experience.'],
                        'rating_4' => ['description' => 'The vendor has a clear strategy for a phased migration to minimize risk and downtime, as opposed to a "big bang" rewrite.']
                    ]
                ],
                'section_c' => [
                    'title' => 'Security & Compliance Strategy',
                    'weight' => '20%',
                    'criteria' => [
                        'rating_1' => ['description' => 'The vendor provided a confident and specific plan to remediate the identified security vulnerabilities (SQL Injection, insecure deserialization, etc.).'],
                        'rating_2' => ['description' => 'The vendor’s approach to implementing parameterized queries to fix SQL injection is aligned with best practices.'],
                        'rating_3' => ['description' => 'The vendor demonstrated a strong commitment to data security and privacy principles appropriate for sensitive patient data.'],
                        'rating_4' => ['description' => 'The vendor’s plan for implementing Two-Factor Authentication (2FA) is clear and technically sound.']
                    ]
                ],
                'section_d' => [
                    'title' => 'Future-Proofing & Roadmap Alignment',
                    'weight' => '20%',
                    'criteria' => [
                        'rating_1' => ['description' => 'The proposed architecture appears scalable and capable of supporting future roadmap features (AI/ML, DICOM integration, Smart Documentation).'],
                        'rating_2' => ['description' => 'The vendor agrees that a modern, service-oriented foundation is a prerequisite for advanced capabilities like AI/ML.'],
                        'rating_3' => ['description' => 'The vendor presented a viable approach for viewer-level imaging integration and interfacing with external PACS systems.'],
                        'rating_4' => ['description' => 'The vendor has relevant ideas or experience in implementing "Smart Documentation" features (NLP, Voice-to-Text, etc.).']
                    ]
                ],
                'section_e' => [
                    'title' => 'Project Management & Collaboration',
                    'weight' => '10%',
                    'criteria' => [
                        'rating_1' => ['description' => 'The vendor’s project management methodology (e.g., Agile/Scrum) is well-defined and suits our needs.'],
                        'rating_2' => ['description' => 'The plan for communication, stakeholder engagement, and progress reporting is transparent and frequent.'],
                        'rating_3' => ['description' => 'The vendor has a clear plan for knowledge transfer to ensure our internal team can maintain the system post-launch.'],
                        'rating_4' => ['description' => 'The vendor appears to be a collaborative partner rather than just a contractor.']
                    ]
                ],
                'section_f' => [
                    'title' => 'Cost & Commercials',
                    'weight' => '10%',
                    'criteria' => [
                        'rating_1' => ['description' => 'The vendor provided a clear, detailed, and transparent cost breakdown for the entire project.'],
                        'rating_2' => ['description' => 'The proposed Total Cost of Ownership (TCO), including licensing and initial investment, appears reasonable for the value offered.'],
                        'rating_3' => ['description' => 'The post-launch support and maintenance costs (Annual Maintenance Cost - AMC) are clearly defined and seem sustainable.'],
                        'rating_4' => ['description' => 'The proposed timeline aligns with our expectation of approximately 18 months.']
                    ]
                ]
            ];
        }
        return [];
    }

    public function showResult($id)
    {
        $evaluation = VendorEvaluation::findOrFail($id);
        $sectionsConfig = $this->getSectionsConfig($evaluation->form_type);
        return view('evaluations.show', compact('evaluation', 'sectionsConfig'));
    }


    public function store(Request $request)
    {
        $formType = $request->input('form_type');

        Evaluator::firstOrCreate(['name' => $request->input('evaluator_name')]);

        if ($formType === 'A') {
            $validator = Validator::make($request->all(), [
                'vendor_name' => 'required|string|max:255',
                'evaluator_name' => 'required|string|max:255',
                'meeting_date' => 'required|date',
                'form_type' => 'required|in:A',
                'scores' => 'required|array',
                'comments' => 'required|array',
                'key_strengths' => 'required|string',
                'areas_for_improvement' => 'required|string',
                'recommendation' => 'required|string',
                'final_comments' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Calculate weighted scores for Form A
            $sectionsConfig = $this->getSectionsConfig('A');
            $total_score = 0;
            $sectionData = [];

            foreach ($sectionsConfig as $sectionKey => $sectionDetails) {
                $scores = collect($request->input("scores.$sectionKey"))->filter()->avg();
                $total_score += $scores * (float)str_replace('%', '', $sectionDetails['weight']) / 100;

                $sectionContent = [];
                foreach ($sectionDetails['criteria'] as $criterionKey => $criterionDetails) {
                    $score = $request->input("scores.$sectionKey.$criterionKey");
                    $comment = $request->input("comments.$sectionKey.$criterionKey");

                    $sectionContent[$criterionKey] = [
                        'score' => $score,
                        'comment' => $comment,
                    ];
                }
                $sectionData[$sectionKey] = $sectionContent;
            }
            $total_score = $total_score * 20; // Scale to 100

            VendorEvaluation::create(array_merge($request->except(['scores', 'comments']), [
                'user_id' => auth()->id(),
                'form_type' => 'A',
                'evaluation_date' => $request->meeting_date,
                'total_score' => $total_score,
                'section_a' => $sectionData['section_a'] ?? [],
                'section_b' => $sectionData['section_b'] ?? [],
                'section_c' => $sectionData['section_c'] ?? [],
                'section_d' => $sectionData['section_d'] ?? [],
                'section_e' => $sectionData['section_e'] ?? [],
                'section_f' => $sectionData['section_f'] ?? [],
            ]));
        } elseif ($formType === 'B') {
            $validator = Validator::make($request->all(), [
                'vendor_name' => 'required|string|max:255',
                'evaluator_name' => 'required|string|max:255',
                'evaluation_date' => 'required|date',
                'form_type' => 'required|in:B',
                'sections' => 'required|array',
                'key_strengths' => 'required|string',
                'key_risks' => 'required|string',
                'recommendation' => 'required|string'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $sections = $request->input('sections');
            $allScores = [];
            $sectionData = [];

            foreach ($sections as $sectionKey => $sectionContent) {
                $sectionRatings = [];
                if (isset($sectionContent['ratings'])) {
                    foreach ($sectionContent['ratings'] as $ratingKey => $rating) {
                        $sectionRatings[$ratingKey] = [
                            'score' => $rating['score'] ?? null,
                        ];

                        if (isset($rating['score']) && is_numeric($rating['score'])) {
                            $allScores[] = (int)$rating['score'];
                        }
                    }
                }
                $sectionData["section_".$sectionKey] = [
                    'ratings' => $sectionRatings,
                    'comments' => $sectionContent['comments'] ?? null,
                ];
            }

            $total_score = 0;
            if (count($allScores) > 0) {
                $averageScore = array_sum($allScores) / count($allScores);
                $total_score = ($averageScore / 5) * 100;
            }

            VendorEvaluation::create([
                'user_id' => auth()->id(),
                'form_type' => 'B',
                'vendor_name' => $request->vendor_name,
                'evaluator_name' => $request->evaluator_name,
                'evaluation_date' => $request->input('evaluation_date'),
                'section_a' => $sectionData['section_a'] ?? [],
                'section_b' => $sectionData['section_b'] ?? [],
                'section_c' => $sectionData['section_c'] ?? [],
                'section_d' => $sectionData['section_d'] ?? [],
                'section_e' => $sectionData['section_e'] ?? [],
                'section_f' => $sectionData['section_f'] ?? [],
                'key_strengths' => $request->key_strengths,
                'key_risks' => $request->key_risks,
                'recommendation' => $request->recommendation,
                'total_score' => $total_score
            ]);
        }

        return redirect()->route('evaluations.show', $formType)
            ->with('success', 'Evaluation submitted successfully!');
    }
}

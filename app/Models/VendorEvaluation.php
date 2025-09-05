<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
        'form_type',
        'vendor_name',
        'evaluator_name',
        'evaluation_date',
        'section_a',
        'section_b',
        'section_c',
        'section_d',
        'section_e',
        'section_f',
        'key_strengths',
        'key_risks',
        'areas_for_improvement',
        'recommendation',
        'final_comments',
        'total_score'
    ];

    protected $casts = [
         'section_a' => 'array',
        'section_b' => 'array',
        'section_c' => 'array',
        'section_d' => 'array',
        'section_e' => 'array',
        'section_f' => 'array',
        'evaluation_date' => 'date',
        'total_score' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormNameAttribute()
    {
        if ($this->form_type === 'A') {
            return 'HMIS Vendor Evaluation (Form A)';
        } elseif ($this->form_type === 'B') {
            return 'Refactoring Evaluation Form (Form B)';
        }

        return 'Unknown Form';
    }

    public function getEvaluationDataAttribute()
    {
        return array_merge(
            $this->section_a ?? [],
            $this->section_b ?? [],
            $this->section_c ?? [],
            $this->section_d ?? [],
            $this->section_e ?? [],
            $this->section_f ?? [],
            [
                'key_strengths' => $this->key_strengths,
                'key_risks' => $this->key_risks,
                'areas_for_improvement' => $this->areas_for_improvement,
                'recommendation' => $this->recommendation,
                'final_comments' => $this->final_comments,
                'total_score' => $this->total_score,
            ]
        );
    }
}
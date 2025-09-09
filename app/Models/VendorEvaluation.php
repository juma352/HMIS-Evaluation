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
        'final_committee_comment',
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
                'final_committee_comment' => $this->final_committee_comment,
                'total_score' => $this->total_score,
            ]
        );
    }

    public function getSectionAvg($section)
    {
        $data = $this->{$section};
        if (!$data) return 0.00;

        if ($this->form_type === 'A') {
            $scores = collect($data)->pluck('score')->filter()->map(fn($s) => (float) $s);
        } else {
            $scores = collect($data['ratings'] ?? [])->pluck('score')->filter(fn($s) => $s && $s !== 'N/A')->map(fn($s) => (float) $s);
        }

        return $scores->count() > 0 ? $scores->avg() : 0.00;
    }

    public function sectionAAvg() { return $this->getSectionAvg('section_a'); }
    public function sectionBAvg() { return $this->getSectionAvg('section_b'); }
    public function sectionCAvg() { return $this->getSectionAvg('section_c'); }
    public function sectionDAvg() { return $this->getSectionAvg('section_d'); }
    public function sectionEAvg() { return $this->getSectionAvg('section_e'); }
    public function sectionFAvg() { return $this->getSectionAvg('section_f'); }

    public function getEvaluationDateAttribute($value)
    {
        if ($value instanceof \DateTime) {
            return $value;
        }
        if (is_string($value) && !empty($value)) {
            try {
                return new \DateTime($value);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    
}
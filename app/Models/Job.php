<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'job_code',
        'title',
        'roles_and_responsibility',
        'company',
        'hr_incharge',
        'email',
        'salary',
        'location',
        'job_category_id',
        'industry_type_id',
        'client_id',
        'experience_min',
        'experience_max',
        'currency_id',
        'salary_from',
        'salary_to',
        'opening_date',
        'closing_date',
        'gender_preference',
        'job_type_id'
    ];

    protected $casts = [
        'opening_date' => 'date',
        'closing_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function industryType()
    {
        return $this->belongsTo(IndustryType::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class JobApplication extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['job_id', 'name', 'phone', 'email', 'resume'];
    
    protected $appends = ['resume_url'];

    public function getResumeUrlAttribute()
    {
        return $this->getFirstMediaUrl('resume');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}

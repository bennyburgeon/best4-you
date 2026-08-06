<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title', 
        'logo', 
        'contact_number', 
        'contact_email', 
        'verified',
        'hr_name',
        'hr_contact',
        'hr_email'
    ];
    
    protected $appends = ['logo'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
             ->useDisk('s3')
             ->singleFile();
    }

    public function getLogoAttribute($value)
    {
        $media = $this->getFirstMediaUrl('logo');
        return $media ?: $value;
    }
}

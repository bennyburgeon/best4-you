<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'slug', 'status'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}

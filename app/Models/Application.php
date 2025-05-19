<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'job_post_id',
        'job_seeker_id',
        'name',
        'email',
        'contact_number',
        'latest_degree',
        'institute',
        'cgpa',
        'expected_salary',
        'github_profile',
        'cv'
    ];

    public function job(){
        return $this->belongsTo(JobPost::class,'job_post_id');
    }

    public function job_seeker()  {
        return $this->belongsTo(User::class,'job_seeker_id');
    }
}

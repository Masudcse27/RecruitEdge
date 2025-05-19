<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'employer_id',
        'title',
        'company_name',
        'description',
        'location',
        'employment_type',
        'salary',
        'deadline',
        'is_approved'
    ];

    public function employer(){
        return $this->belongsTo(User::class,'employer_id');
    }

    public function applications(){
        return $this->hasMany(Application::class,'job_post_id');
    }
    
}

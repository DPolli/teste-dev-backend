<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'contractor',
        'type',
        'status',
        'description',
        'user_id'
    ];

    public function recruiter()
    {
        return $this->belongsTo(User::class);
    }
    
}

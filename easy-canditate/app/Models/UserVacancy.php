<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserVacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'vacancy_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
    
}

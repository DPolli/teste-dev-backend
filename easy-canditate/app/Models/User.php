<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'type',
        'password',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }

    public function isRecruiter(): bool
    {
        return $this->type === 'Recrutador';
    }

    public function isCandidate(): bool
    {
        return $this->type === 'Candidato';
    }

    public function isAdmin(): bool
    {
        return $this->is_admin == true;
    }

}

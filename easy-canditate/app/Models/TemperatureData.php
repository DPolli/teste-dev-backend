<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class TemperatureData extends Model
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'value',
        'date'
    ];

}

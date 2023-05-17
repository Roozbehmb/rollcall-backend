<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyShift extends Model
{
    use HasFactory;
    protected $fillable=[
        'title_weeklyshift',
        'select_shift',
        'days_week',
        'Jaegerin_Vacation',
        'general_shift'
    ];
}

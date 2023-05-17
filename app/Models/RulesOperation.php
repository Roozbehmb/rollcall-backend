<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RulesOperation extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description',
        'right_leave',
        'time_right_leave',
        'max_overtime',
        'time_max_overtime',
        'max_working_holiday',
        'time_working_holiday	',
        'max_working_Friday',
        'time_working_Friday',
        'traffic_time_limit',
        'time_time_limit',
        'limit_forgotten',
        'time_limit_forgotten',
        'limit_forgotten_sel	',
        'time_limit_forgotten_sel',
        'forgotten_traffic_count',
        'time_forgotten_traffic_count',
        'overtime_overlap',
        'overcalculation',
    ];
}

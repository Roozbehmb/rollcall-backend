<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetAbsent extends Model
{
    use HasFactory;
    protected $table='set_absents';
    protected $fillable=[
        'id_listEmployees',
        'id_absence',
        'date',
        'days',
        'description'

    ];
}

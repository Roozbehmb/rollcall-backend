<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftWorkDaily extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'shift_work__dailies';

}

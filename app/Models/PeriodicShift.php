<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodicShift extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'periodic_shifts';

    public function getShift()
    {
        return $this->hasOne(ShiftDailie::class, 'id', 'id_shift_work_dailies');
    }
}

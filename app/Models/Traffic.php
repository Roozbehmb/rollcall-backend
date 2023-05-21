<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'traffics';
//    protected $with = ['get_user'];

    public function get_user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function get_absents()
    {
        return $this->hasOne(Absence::class, 'id', 'id_absents');
    }

    public function get_substitute()
    {
        return $this->hasOne(ShiftDailie::class, 'id', 'id_substitute');
    }

    public function get_mission()
    {
        return $this->hasOne(Mission::class, 'id', 'id_mission');
    }

    public function get_day()
    {
        return $this->hasOne(DayWeek::class, 'id', 'id_day');
    }

    public function get_employee()
    {
        return $this->hasOne(ShiftEmployee::class, 'id', 'id_shift');
    }


}

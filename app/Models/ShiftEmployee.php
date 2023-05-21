<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftEmployee extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    protected $guarded = [];
    protected $table = 'shift_employees';


    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(User::class, 'id', 'user_id');
    }

    public function shiftWeek(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(WeeklyShift::class, 'id', 'week_shift_id');
    }

    public function shiftPeriodic(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(PeriodicShift::class, 'id', 'periodic_shift_id');
    }

    public function shiftDay(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(ShiftDailie::class, 'id', 'shift_dailies_id');
    }

    public function shiftDedicated(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(ShiftDailie::class, 'id_user', 'shift_dailies_id');
    }

    public function get_absents_default()
    {
        return $this->HasMany(Absence::class, 'id', 'id_absents');
    }

    public function get_week_shift()
    {
        return $this->HasMany(WeeklyShift::class, 'id', 'id_week_shift');
    }

    public function get_shift_dailies()
    {
        return $this->HasMany(ShiftDailie::class, 'id', 'id_shift_dailies');
    }

    public function get_periodic_shift()
    {
        return $this->HasMany(PeriodicShift::class, 'id', 'id_periodic_shift');
    }

    public function get_dedicated_shift()
    {
        return $this->HasMany(ShiftDailie::class, 'id', 'id_dedicated_shift');
    }

    public function get_days()
    {
        return $this->HasMany(DayWeek::class, 'id', 'id_day');
    }
}

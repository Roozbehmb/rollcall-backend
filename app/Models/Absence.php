<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function get_absents_type()
    {
        return $this->hasOne(TypeAbsence::class, 'id', 'id_type_absence');
    }


}

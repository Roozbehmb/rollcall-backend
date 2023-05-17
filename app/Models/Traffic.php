<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'traffics';
    public function get_user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}

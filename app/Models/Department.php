<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function rooms()
    {
        return $this->belongsToMany('App\Models\Room', 'department_room');
    }
}

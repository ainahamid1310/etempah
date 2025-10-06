<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function departments()
    {
        return $this->belongsToMany('App\Models\Department', 'department_room');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'room_user');
    }

    public function roomUsers()
    {
        return $this->hasMany('App\Models\RoomUser');
    }
}

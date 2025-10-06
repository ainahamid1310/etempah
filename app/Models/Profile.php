<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $fillable = ['user_id', 'department_id', 'position_id', 'no_extension', 'no_bimbit'];
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\Position');
    }

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade');
    }
}

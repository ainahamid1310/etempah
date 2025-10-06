<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['id', 'nama', 'email', 'no_telefon_office', 'role', 'status'];
}

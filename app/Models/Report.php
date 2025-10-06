<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $table = 'reports';
    protected $fillable = ['deleted_by'];

    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }
}

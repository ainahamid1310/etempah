<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationVc extends Model
{
    protected $fillable = [
    'application_id',
    'status_vc_id',
    'webex',
    'nama_aplikasi',
    'peralatan',
    'tarikh_keputusan',
    'catatan',
    'catatan_penyelia',
    'action_by',
    'created_by',
];
    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }

    public function statusVc()
    {
        return $this->belongsTo('App\Models\StatusVc', 'status_vc_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationRoom extends Model
{
    protected $fillable = [
    'application_id',
    'status_room_id',
    'nama_urusetia',
    'position_id',
    'department_id',
    'emel_urusetia',
    'no_extension_urusetia',
    'no_telefon_bimbit_urusetia',
    'penganjur',
    'nama_penganjur',
    'kategori_mesyuarat',
    'surat',
    'ahli',
    'sajian',
    'minum_pagi',
    'makan_tengahari',
    'minum_petang',
    'komen_ditolak',
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

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function grade()
    {
        return $this->hasOne('App\Models\Grade');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\Position');
    }

    public function statusRoom()
    {
        return $this->belongsTo('App\Models\StatusRoom');
    }
}

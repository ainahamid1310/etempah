<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Application extends Model
{
    protected $fillable = [
        'batch_id',
        'room_id',
        'tarikh_mula',
        'tarikh_hingga',
        'user_id',
        'nama_mesyuarat',
        'kategori_pengerusi',
        'nama_pengerusi',
        'bilangan_tempahan',
        'perakuan',
        'created_by',
    ];

    protected $casts = [
        'tarikh_mula'   => 'datetime',
        'tarikh_hingga' => 'datetime',
    ];
    
    public static function dashboardAdminRoom()
    {
        $user = User::where('is_admin', 1)
            ->where('id', Auth::user()->id)
            ->first();

        if (!empty($user->id)) {
            $user_id = $user->id;
        } else {
            $user_id = '';
        }

        $role = $user->getRoleNames();

        // if ($role == 'super-admin' || $role == 'biz-point' || $role == 'pmsb') {
        // $user->hasRole(['editor', 'moderator']);
        if ($user->hasRole(['super-admin', 'biz-point', 'pmsb'])) {

            $baru = ApplicationRoom::where('status_room_id', '1')
                ->whereHas('application', function ($query) {
                    return $query->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $lulus = ApplicationRoom::whereIn('status_room_id', ['2', '14'])
                ->whereHas('application', function ($query) {
                    return $query->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();
            $tolak = ApplicationRoom::whereIn('status_room_id', ['4', '5'])
                ->whereHas('application', function ($query) {
                    return $query->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            // $tolak = ApplicationRoom::join('applications', 'applications.id', '=', 'application_rooms.application_id')

            $batal = ApplicationRoom::whereIn('status_room_id', ['5', '7', '12', '13'])
                ->whereHas('application', function ($query) {
                    return $query->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $dalam_proses = ApplicationRoom::where('status_room_id', '3')
                ->whereHas('application', function ($query) {
                    return $query->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $selesai = ApplicationRoom::whereIn('status_room_id', ['2', '4', '5', '6', '7', '11', '12', '13', '14'])
                ->whereHas('application', function ($query) {
                    return $query->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $jumlah = ApplicationRoom::whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();
        } else {
            // Bilik Penyelia

            $rooms = Room::whereHas('users', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->pluck('id')->toArray();

            $baru = ApplicationRoom::where('status_room_id', '1')
                ->whereHas('application', function ($query) use ($rooms) {
                    return $query->whereIn('room_id', $rooms)->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $lulus = ApplicationRoom::whereIn('status_room_id', ['2', '14'])
                ->whereHas('application', function ($query) use ($rooms) {
                    return $query->whereIn('room_id', $rooms)->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $tolak = ApplicationRoom::whereIn('status_room_id', ['4', '5'])
                ->whereHas('application', function ($query) use ($rooms) {
                    return $query->whereIn('room_id', $rooms)->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $batal = ApplicationRoom::whereIn('status_room_id', ['5', '7', '12', '13'])
                ->whereHas('application', function ($query) use ($rooms) {
                    return $query->whereIn('room_id', $rooms)->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $dalam_proses = ApplicationRoom::where('status_room_id', '3')
                ->whereHas('application', function ($query) use ($rooms) {
                    return $query->whereIn('room_id', $rooms)->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $selesai = ApplicationRoom::whereIn('status_room_id', ['2', '4', '5', '6', '7', '11', '12', '13', '14'])
                ->whereHas('application', function ($query) use ($rooms) {
                    return $query->whereIn('room_id', $rooms)->whereBetween('tarikh_mula', [
                        Carbon::now()->startOfYear(),
                        Carbon::now()->endOfYear(),
                    ]);
                })->count();

            $jumlah = ApplicationRoom::whereHas('application', function ($query) use ($rooms) {
                return $query->whereIn('room_id', $rooms)->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();
        }

        $status = ['baru' => $baru, 'dalam_proses' => $dalam_proses, 'selesai' => $selesai, 'jumlah' => $jumlah];

        $today_list =  DB::table('calendar')->where('tarikh_hingga', '>=', now()->toDateString())
            ->where('tarikh_mula', '<=', now()->toDateString())->get();
        return view('dashboard_admin', compact('status', 'today_list',));
    }

    public static function dashboardAdminVc()
    {
        // $user = User::role('approver-vc')->where('is_admin', 1)
        // ->where('id', Auth::user()->id)
        //     ->first();

        $baru = ApplicationVc::where('status_vc_id', '1')
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $dalam_proses = ApplicationVc::where('status_vc_id', '2')
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $selesai = ApplicationVc::whereIn('status_vc_id', ['3', '4', '5', '10', '11', '12'])
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $jumlah = ApplicationVc::whereHas('application', function ($query) {
            return $query->whereBetween('tarikh_mula', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ]);
        })->count();

        $lulus = ApplicationVc::whereIn('status_vc_id', ['3', '12'])
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $tolak = ApplicationVc::where('status_vc_id', '4')
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $batal = ApplicationVc::whereIn('status_vc_id', ['5', '10', '11'])
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $status = ['baru' => $baru, 'dalam_proses' => $dalam_proses, 'selesai' => $selesai, 'jumlah' => $jumlah];
        $statusPie = ['dalam_proses' => $dalam_proses, 'lulus' => $lulus, 'tolak' => $tolak, 'batal' => $batal]; //buang dlm proses
        $top5 = ['rank1' => 50, 'rank2' => 40, 'rank3' => 30, 'rank4' => 20, 'rank5' => 10];
        $today_list =  DB::table('calendar_vc')->where('tarikh_hingga', '>=', now()->toDateString())
            ->where('tarikh_mula', '<=', now()->toDateString())->get();

        return view('dashboard_admin', compact('status', 'today_list',));
    }

    public static function charts()
    {
        $baru = ApplicationRoom::where('status_room_id', '1')
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $lulus = ApplicationRoom::whereIn('status_room_id', ['2', '11', '14'])
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $tolak = ApplicationRoom::whereIn('status_room_id', ['4', '5'])
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $batal = ApplicationRoom::whereIn('status_room_id', ['5', '7', '12', '13'])
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $dalam_proses = ApplicationRoom::where('status_room_id', '3')
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $selesai = ApplicationRoom::whereIn('status_room_id', ['2', '4', '5', '6', '7', '11', '12', '13', '14'])
            ->whereHas('application', function ($query) {
                return $query->whereBetween('tarikh_mula', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ]);
            })->count();

        $jumlah = ApplicationRoom::count();

        $barcharts = DB::table('application_rooms')
            ->select(DB::raw('COUNT(rooms.nama) as jumlah'), 'rooms.nama')
            ->leftJoin('applications', 'applications.id', '=', 'application_rooms.application_id')
            ->leftJoin('rooms', 'rooms.id', '=', 'applications.room_id')
            ->whereIn('status_room_id', ['2', '6', '11', '14'])
            ->groupBy('rooms.nama')
            ->LIMIT(5)
            ->get();


        $status = ['baru' => $baru, 'dalam_proses' => $dalam_proses, 'selesai' => $selesai, 'jumlah' => $jumlah];
        $statusPie = ['dalam_proses' => $dalam_proses, 'lulus' => $lulus, 'tolak' => $tolak, 'batal' => $batal]; //buang dlm proses
        $top5 = ['rank1' => 50, 'rank2' => 40, 'rank3' => 30, 'rank4' => 20, 'rank5' => 10];

        return view('laporan.statistik', compact('status', 'top5', 'statusPie', 'barcharts'));
    }

    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function department()
    {
        return $this->hasOne('App\Models\Department');
    }

    public function grade()
    {
        return $this->hasOne('App\Models\Grade');
    }

    public function position()
    {
        return $this->hasOne('App\Models\Position');
    }

    public function applicationRoom()
    {
        return $this->hasOne('App\Models\ApplicationRoom');
    }

    public function applicationVC()
    {
        return $this->hasOne('App\Models\ApplicationVc');
    }

    public function amends()
    {
        return $this->hasMany('App\Models\Amend');
    }

    public function rooms()
    {
        return $this->belongsToMany(
            'App\Models\Room',
            'room_user',
            'room_id',
            'user_id'
        );
    }

    public function report()
    {
        return $this->hasOne('App\Models\Report');
    }

    public function batch()
    {
        return $this->belongsTo('App\Models\Batch');
    }
}

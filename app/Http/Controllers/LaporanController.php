<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\ApplicationRoom;
use App\Models\ApplicationVc;
use App\Models\StatusVc;
use App\Models\User;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $biliks = DB::table('rooms')->get();

        $bahagians = DB::table('departments')->get();

        $submit = $request['submit'];
        $nama_bilik = $request->nama_bilik;
        $bahagian = $request->bahagian;
        $tarikh = $request->datetime;
        $cari = $request->cari;

        $bahagianx = $request->bahagian;
        $tarikhx = $request->datetime;

        $carian = $this->filterCarian($nama_bilik, $bahagian, $tarikh)->orderby('id', 'desc')->get();

        return view('laporan.pmsb', compact('biliks', 'bahagians', 'cari', 'carian', 'nama_bilik', 'bahagianx', 'tarikhx'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function filterCarian($nama_bilik, $bahagian, $tarikh)
    {

        $carian = DB::table('pmsb');

        if ($nama_bilik != "") {
            $carian = $carian->where('room_id',  $nama_bilik);
        }

        if ($bahagian != "") {
            $carian = $carian->where('department_id', '=', $bahagian);
        }


        if ($tarikh != '') {
            $st_dt = $tarikh;
            // $start = date(Carbon\Carbon::createFromFormat('d/m/Y', $st_dt)->format('Y-m-d'));
            $newdate = date(Carbon\Carbon::createFromFormat('m/d/Y', $st_dt)->format('Y-m-d'));
            $carian = $carian->where('tarikh_mula', '=', $newdate);
        }


        return $carian;
    }

    public function biz(Request $request)
    {
        $biliks = DB::table('rooms')->get();

        $bahagians = DB::table('departments')->get();

        $submit = $request['submit'];
        $nama_bilik = $request->nama_bilik;
        $bahagian = $request->bahagian;
        $tarikh = $request->datetime;
        $cari = $request->cari;

        $bahagianx = $request->bahagian;
        $tarikhx = $request->datetime;

        $carian = $this->filterCarian($nama_bilik, $bahagian, $tarikh)->orderby('id', 'desc')->get();

        return view('laporan.biz', compact('biliks', 'bahagians', 'cari', 'carian', 'nama_bilik', 'bahagianx', 'tarikhx'));
    }

    public function bilik(Request $request)
    {
        $rooms = DB::table('rooms')->get();

        $departments = DB::table('departments')->get();

        $submit = $request['submit'];
        $nama_bilik = $request->nama_bilik;
        $bahagian = $request->bahagian;
        $status = $request->status;
        $pengerusi = $request->pengerusi;
        $tarikhdari = $request->date_start;
        $tarikhhingga = $request->date_end;
        $cari = $request->cari;

        $bahagian_selected = $request->bahagian;
        $tarikh_selected = $request->datetime;

        $carian = $this->filterCarianBilik($nama_bilik, $bahagian, $status, $pengerusi, $tarikhdari, $tarikhhingga)->get();

        return view('laporan.tempahan_bilik', compact('rooms', 'departments', 'cari', 'carian', 'nama_bilik', 'status', 'pengerusi', 'bahagian_selected', 'tarikh_selected'));
    }

    public function filterCarianBilik($nama_bilik, $bahagian, $status, $pengerusi, $tarikhdari, $tarikhhingga)
    {
        // $carian = ApplicationRoom::join('applications', 'applications.id', '=', 'application_rooms.application_id')->orderBy('tarikh_mula', 'DESC');

        // Request by user nak tukar sort by tarikh kelulusan (Tarikh_keputusan)
        $carian = ApplicationRoom::join('applications', 'applications.id', '=', 'application_rooms.application_id')->orderBy('tarikh_keputusan', 'ASC');

        if ($nama_bilik != "") {
            $carian = $carian->where('room_id',  $nama_bilik);
        }

        if ($bahagian != "") {
            $carian = $carian->where('department_id', '=', $bahagian);
        }

        if ($status != "") {
            if ($status == '2') {
                $carian = $carian->whereIn('status_room_id', [2, 6, 11, 14]);
            } elseif ($status == '5') {
                $carian = $carian->whereIn('status_room_id', [5, 7, 12, 13]);
            } else {
                $carian = $carian->whereIn('status_room_id', [$status]);
            }
        }

        if ($pengerusi != "") {
            $carian = $carian->where('kategori_pengerusi', '=', $pengerusi);
        }

        if ($tarikhdari != '' && $tarikhhingga == '') {
            $carian = $carian->whereDate('tarikh_mula', '=', $tarikhdari);
        } else {
            if ($tarikhdari != '') {
                $toDate = Carbon::parse($tarikhhingga);
                $tarikhhingga = $toDate->addDay(1)->format('Y-m-d H:i:s');
                $carian = $carian->where('tarikh_mula', '<=', $tarikhhingga);
            }

            if ($tarikhhingga != '') {
                $endDate = Carbon::parse($tarikhdari);
                $tarikhdari = $endDate->format('Y-m-d H:i:s');
                $carian = $carian->where('tarikh_hingga', '>=', $tarikhdari);
            }
        }

        return $carian;
    }

    public function aduan(Request $request)
    {

        $biliks = DB::table('rooms')->get();

        $bahagians = DB::table('departments')->get();

        $submit = $request['submit'];
        $nama_bilik = $request->nama_bilik;
        $bahagian = $request->bahagian;
        $tarikhdari = $request->datedari;
        $tarikhhingga = $request->datehingga;
        $cari = $request->cari;

        $bahagianx = $request->bahagian;
        $tarikhx = $request->datetime;

        $carian = $this->filterCarianAduan($nama_bilik, $bahagian, $tarikhdari, $tarikhhingga)->orderby('id', 'desc')->get();

        return view('laporan.aduan', compact('biliks', 'bahagians', 'cari', 'carian', 'nama_bilik', 'bahagianx', 'tarikhx'));
    }

    public function filterCarianAduan($nama_bilik, $bahagian, $tarikhdari, $tarikhhingga)
    {

        $carian = DB::table('laporan_aduan');

        if ($nama_bilik != "") {
            $carian = $carian->where('room_id',  $nama_bilik);
        }

        if ($bahagian != "") {
            $carian = $carian->where('department_id', '=', $bahagian);
        }


        if ($tarikhdari != '' && $tarikhhingga != '') {
            $st_dt = $tarikhdari;
            $st_dt2 = $tarikhhingga;
            // $start = date(Carbon\Carbon::createFromFormat('d/m/Y', $st_dt)->format('Y-m-d'));
            $newdate = date(Carbon\Carbon::createFromFormat('m/d/Y', $st_dt)->format('Y-m-d'));
            $newdate2 = date(Carbon\Carbon::createFromFormat('m/d/Y', $st_dt2)->format('Y-m-d'));
            //$carian = $carian->where('tarikh_mula', '=', $newdate)->where('tarikh_hingga', '=', $newdate2);
            $carian = $carian->whereBetween('tarikh_reports', [$newdate, $newdate2]);
        }

        if ($tarikhdari != '') {
            $st_dt = $tarikhdari;
            $newdate = date(Carbon\Carbon::createFromFormat('m/d/Y', $st_dt)->format('Y-m-d'));
            $carian = $carian->where('tarikh_reports', '>=', $newdate);
        }

        if ($tarikhhingga != '') {
            $st_dt = $tarikhhingga;
            $newdate = date(Carbon\Carbon::createFromFormat('m/d/Y', $st_dt)->format('Y-m-d'));
            $carian = $carian->where('tarikh_reports', '<=', $newdate);
        }

        return $carian;
    }

    public function vc(Request $request)
    {
        $submit = $request['submit'];
        $cari = $request->cari;
        $tarikhdari = $request->date_start;
        $tarikhhingga = $request->date_end;

        $status = $request->status;

        $laporan_vcs = $this->filterCarianVc($status, $tarikhdari, $tarikhhingga)->get();

        return view('laporan.vc', compact('cari', 'laporan_vcs', 'status', 'tarikhdari', 'tarikhhingga'));
    }

    public function filterCarianVc($status_selected, $tarikhdari, $tarikhhingga)
    {
        $laporan_vcs = ApplicationVc::join('applications', 'applications.id', '=', 'application_vcs.application_id')
            ->orderBy('tarikh_mula', 'DESC');

        if ($status_selected != "") {
            if ($status_selected == '2') {
                $laporan_vcs = $laporan_vcs->whereIn('status_vc_id', [1, 2]);
            } elseif ($status_selected == '3') {
                $laporan_vcs = $laporan_vcs->whereIn('status_vc_id', [3, 12]);
            } elseif ($status_selected == '4') {
                $laporan_vcs = $laporan_vcs->whereIn('status_vc_id', [4]);
            } elseif ($status_selected == '5') {
                $laporan_vcs = $laporan_vcs->whereIn('status_vc_id', [5, 10, 11]);
            }
        }

        if ($tarikhdari != '' && $tarikhhingga == '') {
            $carian = $laporan_vcs->whereDate('tarikh_mula', '=', $tarikhdari);
        } else {
            if ($tarikhdari != '') {
                $toDate = Carbon::parse($tarikhhingga);
                $tarikhhingga = $toDate->addDay(1)->format('Y-m-d H:i:s');
                $carian = $laporan_vcs->where('tarikh_mula', '<=', $tarikhhingga);
            }

            if ($tarikhhingga != '') {
                $endDate = Carbon::parse($tarikhdari);
                $tarikhdari = $endDate->format('Y-m-d H:i:s');
                $carian = $carian->where('tarikh_hingga', '>=', $tarikhdari);
            }
        }

        return $laporan_vcs;
    }

    public function tempahan(Request $request, $layout_role)
    {
        $rooms = Room::get();
        $submit = $request['submit'];

        $mesyuarat = $request->nama_mesyuarat;
        $id_permohonan = $request->id_permohonan;
        $bilik = $request->nama_bilik;
        $tarikhdari = $request->date_start;
        $tarikhhingga = $request->date_end;
        $cari = $request->cari;

        $carian = $this->filterSearch($mesyuarat, $bilik, $tarikhdari, $tarikhhingga, $id_permohonan, $layout_role)->get();

        if ($layout_role == 'pengguna') {
            return view('applications.search_applicant', compact('cari', 'rooms', 'carian', 'bilik', 'mesyuarat', 'id_permohonan', 'layout_role'));
        } elseif ($layout_role == 'admin_room' || $layout_role == 'admin_vc') {
            return view('applications.search_admin', compact('cari', 'rooms', 'carian', 'bilik', 'mesyuarat', 'id_permohonan', 'layout_role'));
        }
    }

    public function filterSearch($mesyuarat, $bilik, $tarikhdari, $tarikhhingga, $id_permohonan, $layout_role)
    {
        $user = User::where('id', Auth::user()->id)
            ->first();
        $carian = Application::orderBy('tarikh_mula', 'DESC');
        if ($user->hasRole(['approver-room'])) {
            $carian = ApplicationRoom::join('applications', 'applications.id', '=', 'application_rooms.application_id')->orderBy('tarikh_mula', 'DESC');
        } elseif ($user->hasRole(['approver-vc'])) {
            $carian = ApplicationVc::join('applications', 'applications.id', '=', 'application_vcs.application_id')
                ->orderBy('tarikh_mula', 'DESC');
        } elseif ($user->hasRole(['user'])) {
           $carian = Application::orderBy('tarikh_mula', 'DESC');

        } elseif ($user->hasRole(['super-admin'])) {
            if($layout_role == 'admin_vc'){
                $carian = ApplicationVc::join('applications', 'applications.id', '=', 'application_vcs.application_id')
                ->orderBy('tarikh_mula', 'DESC');
            }elseif($layout_role == 'admin_room'){
                $carian = ApplicationRoom::join('applications', 'applications.id', '=', 'application_rooms.application_id')
                ->orderBy('tarikh_mula', 'DESC');
            }
        }

        if ($mesyuarat != "") {
            $carian = $carian->where('nama_mesyuarat', 'like', '%' . $mesyuarat . '%');
        }

        if ($id_permohonan != "") {
            $carian = $carian->where('applications.id', '=', $id_permohonan);
        }

        if ($bilik != "") {
            $carian = $carian->where('room_id',  $bilik);
        }

        if ($tarikhdari != '' && $tarikhhingga == '') {
            $carian = $carian->whereDate('tarikh_mula', '=', $tarikhdari);
        } elseif ($tarikhdari == '' && $tarikhhingga != '') {
            $carian = $carian->whereDate('tarikh_hingga', '=', $tarikhhingga);
        } else {
            if ($tarikhdari != '') {
                $toDate = Carbon::parse($tarikhhingga);
                $tarikhhingga = $toDate->addDay(1)->format('Y-m-d H:i:s');
                $carian = $carian->where('tarikh_mula', '<=', $tarikhhingga);
            }

            if ($tarikhhingga != '') {
                $carian = $carian->where('tarikh_hingga', '>=', $tarikhdari);
            }
        }

        // if ($tarikhdari != '') {
        //     $carian = $carian->where('tarikh_mula', '<=', $tarikhhingga);
        // }

        // if ($tarikhhingga != '') {
        //     $carian = $carian->where('tarikh_hingga', '>=', $tarikhdari);
        // }

        return $carian;
    }

    public function statistik()
    {
        return Application::charts();
    }

    
}

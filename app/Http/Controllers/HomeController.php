<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\ApplicationRoom;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)
            ->first();

        if (request()->val == '1') {
            if ($user->hasRole(['approver-room|super-admin|biz-point|pmsb'])) {
                return Application::dashboardAdminRoom();
            } elseif ($user->hasRole(['approver-vc'])) {
                return Application::dashboardAdminVc();
            } else {
                return Application::dashboardAdminRoom();
            }
        } elseif (request()->val == '0') {
            return view('dashboard_applicant');
        } else {
            if ($user->hasRole(['approver-room|super-admin|biz-point|pmsb'])) {
                return Application::dashboardAdminRoom();
            } elseif ($user->hasRole(['approver-vc'])) {
                return Application::dashboardAdminVc();
            } elseif ($user->hasRole(['user'])) {
                return view('dashboard_applicant');
            } else { //super admin
                return Application::dashboardAdminRoom();
            }
        }
    }

    public function indexshow(Request $request)
    {
        $user = User::where('id', Auth::user()->id)
            ->first();

        $events = array();

        if ($user->hasRole(['approver-room|super-admin|biz-point|pmsb'])) {
            $bookings =  DB::table('calendar')->get();
        } elseif ($user->hasRole(['approver-vc'])) {
            $bookings =  DB::table('calendar_vc')->get();
        }
        foreach ($bookings as $booking) {

            $color = null;

            $color1 = '#7E7C7C';
            $color2 = '#B02DB6';

            if ($booking->nama_bilik == 'Dewan Perdana')
                $color = $color1;

            if ($booking->nama_bilik == 'Bilik Seminar 1')
                $color = $color1;

            if ($booking->nama_bilik == 'Bilik Seminar 2')
                $color = $color1;

            if ($booking->nama_bilik == 'VIP Holding Room')
                $color = $color1;

            if ($booking->nama_bilik == 'Bilik Bunga Raya (Aras 31)')
                $color = $color2;

            if ($booking->nama_bilik == 'Bilik Dahlia (Aras 31)')
                $color = $color2;

            if ($booking->nama_bilik == 'Bilik Sakura (Aras 31)')
                $color = $color2;

            if ($booking->nama_bilik == 'Dewan Makan Saffron (Aras 31)')
                $color = $color2;

            $events[] = [

                'title' => $booking->nama_bilik,
                'start' => $booking->tarikh_start,
                'end'   => $booking->tarikh_end,
                'color' => $color,
            ];
        }

        return json_encode($events);
    }

    public function modalshow($id)
    {
        $user = User::where('id', Auth::user()->id)
            ->first();

        if ($user->hasRole(['approver-room|super-admin|biz-point|pmsb'])) {
            $bookings =  DB::table('calendar')
                ->where('tarikh_hingga', '>=', $id)
                ->where('tarikh_mula', '<=', $id)->get();
            $tempah = $id;
        } elseif ($user->hasRole(['approver-vc'])) {
            $bookings =  DB::table('calendar_vc')
                ->where('tarikh_hingga', '>=', $id)
                ->where('tarikh_mula', '<=', $id)->get();
            $tempah = $id;
        } else {
            //public
        }

        return view('program_view', compact('bookings', 'tempah'));
    }

    public function penggunashow(Request $request)
    {
        $events = array();
        $bookings =  DB::table('calendar')->get();
        foreach ($bookings as $booking) {

            $color = null;
            $color1 = '#7E7C7C';
            $color2 = '#B02DB6';

            if ($booking->nama_bilik == 'Dewan Perdana')
                $color = $color1;

            if ($booking->nama_bilik == 'Bilik Seminar 1')
                $color = $color1;

            if ($booking->nama_bilik == 'Bilik Seminar 2')
                $color = $color1;

            if ($booking->nama_bilik == 'VIP Holding Room')
                $color = $color1;

            if ($booking->nama_bilik == 'Bilik Bunga Raya (Aras 31)')
                $color = $color2;

            if ($booking->nama_bilik == 'Bilik Dahlia (Aras 31)')
                $color = $color2;

            if ($booking->nama_bilik == 'Bilik Sakura (Aras 31)')
                $color = $color2;

            if ($booking->nama_bilik == 'Dewan Makan Saffron (Aras 31)')
                $color = $color2;

            $events[] = [

                'title' => $booking->nama_bilik,
                'start' => $booking->tarikh_start,
                'end'   => $booking->tarikh_end,
                'color' => $color,
            ];
        }

        return json_encode($events);
    }
    public function modalpenggunashow($id)
    {
        $bookings =  DB::table('calendar')
            ->where('tarikh_hingga', '>=', $id)
            ->where('tarikh_mula', '<=', $id)->get();
        $tempah = $id;

        return view('program_view', compact('bookings', 'tempah'));
    }
}

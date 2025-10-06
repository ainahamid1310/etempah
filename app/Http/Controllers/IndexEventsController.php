<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function events(Request $request)
    {
        
            // dd("User is not login.");
        $bookings =  DB::table('calendar')->get();
        $contacts = Contact::orderBy('role', 'ASC')->get()->groupBy('role');

        $events = array();

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
        return view('welcome_events', compact('events','contacts'));
        // return json_encode($events);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
    public function showevents(Request $request)
    {
        // return $val = request()->val;
        if (Auth::check()) {
            // dd("User is login.")
            $user = User::where('id', Auth::user()->id)
                ->first();
            if ($user->hasRole(['approver-room|super-admin|user|biz-point|pmsb'])) {
                $bookings =  DB::table('calendar')->get();
            } elseif ($user->hasRole(['approver-vc'])) {
                $bookings =  DB::table('calendar_vc')->get();
            }
        } else {
            // dd("User is not login.");
            $bookings =  DB::table('calendar')->get();
        }

        $events = array();

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

    public function modalshow($id, $val)
    {
        if (Auth::check()) {
            // dd("User is login.");
            $user = User::where('id', Auth::user()->id)
                ->first();
            if ($user->hasRole(['approver-room|super-admin|biz-point|pmsb|user'])) {
                $bookings =  DB::table('calendar')
                    ->where('tarikh_hingga', '>=', $id)
                    ->where('tarikh_mula', '<=', $id)->get();
            } elseif ($user->hasRole(['approver-vc'])) {
                $bookings =  DB::table('calendar_vc')
                    ->where('tarikh_hingga', '>=', $id)
                    ->where('tarikh_mula', '<=', $id)->get();
            }
        } else {
            // dd("User is not login.");
            $bookings =  DB::table('calendar')
                ->where('tarikh_hingga', '>=', $id)
                ->where('tarikh_mula', '<=', $id)->get();
        }

        $tempah = $id;
        $contacts = Contact::orderBy('role', 'ASC')->get()->groupBy('role');

        if (!empty($bookings)) {
            return view('welcome_events_view', compact('bookings', 'tempah', 'contacts', 'val'));
        } else {
            return back();
        }
    }
}

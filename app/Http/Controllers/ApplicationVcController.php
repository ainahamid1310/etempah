<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationVc;
use App\Models\Department;
use App\Models\Position;
use App\Models\Profile;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ApplicationVcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        $user = User::role('approver-vc')->where('is_admin', 1)
            ->where('id', Auth::user()->id)
            ->first();

        if ($status == '1') { //Tindakan
            $statuses = ['2'];
        } elseif ($status == '2') { //Rekod
            $statuses = ['3', '4', '5', '9', '10', '11', '12'];
        } elseif ($status == '3') { //Jumlah permohonan
            $statuses = ['1', '2', '3', '4', '5', '10', '11', '12'];
        } elseif ($status == '4') { //Baru
            $statuses = ['1'];
        } elseif ($status == '5') { //Dalam Proses
            $statuses = ['2'];
        } elseif ($status == '6') { //Selesai
            $statuses = ['3', '4', '5', '10', '11', '12'];
        }

        if ($status == 1 || $status == 4 || $status == 5) {
            $tajuk = 'Tindakan Tempahan VC';
        } elseif ($status == 2 || $status == 3 || $status == 6) {
            $tajuk = 'Rekod Tempahan VC';
        }

        // $applications = Application::whereHas('applicationVc', function ($q) use ($statuses) {
        //     $q->whereIn('status_vc_id', $statuses);
        // })->orderBy('tarikh_mula', 'asc')->get();    

        $applications = Application::whereHas('applicationVc', function ($q) use ($statuses) {
                $q->whereIn('status_vc_id', $statuses);
            })
            ->orderBy('tarikh_mula', 'asc')
            ->get()
            ->unique('batch_id'); // hanya 1 rekod setiap batch


        // dd($applications->first());

        if (!empty($user->id)) {
            $applications = $applications;
        } else {
            $applications = [];
        }

        return view('admins.vc_approve.index', compact('applications', 'tajuk', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();
        $id = Auth::id();
        $user = User::where('id', $id)->first();
        $profile = Profile::where('user_id', $id)->first();

        $department = $profile->department_id;

        //List Bilik mengikut department
        $rooms = Room::whereHas('departments', function ($q) use ($department) {
            $q->where('department_id', $department);
        })->orWhere('is_auto', 'N')->get();

        return view('application_vc.create', compact('departments', 'rooms', 'positions', 'user', 'profile'));
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
     * @param  \App\ApplicationVc  $applicationVc
     * @return \Illuminate\Http\Response
     */
    public function show($applicationVc)
    {
        // $applicationVc = decrypt($applicationVc);
        // return $applicationVc;
        $departments = Department::orderBy('nama', 'ASC')->get();

        $positions = Position::orderBy('nama', 'ASC')->get();

        $rooms = Room::orderBy('nama', 'ASC')->get();
        
        $id = Auth::id();

        $user = User::where('id', $id)->first();

        $profile = Profile::where('user_id', $id)->first();

        $application = Application::findOrFail(decrypt($applicationVc));

        $applications = Application::where('batch_id', $application->batch_id)->get();

        $link = url()->current();

        $contains = Str::contains($link, 'admin');

        return view('admins.vc_approve.view', compact('applications','application', 'departments', 'rooms', 'positions', 'user', 'profile', 'contains'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApplicationVc  $applicationVc
     * @return \Illuminate\Http\Response
     */
    public function edit($applicationVcId)
    {

        $applicationVcId = decrypt($applicationVcId);
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();

        $application = Application::where('id', $applicationVcId)->first();
        $department = $application->user->profile->department_id;

        //List Bilik mengikut department
        $rooms = Room::whereHas('departments', function ($q) use ($department) {
            $q->where('department_id', $department);
        })->get();

        return view('admins.vc_approve.edit', compact('application', 'departments', 'rooms', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApplicationVc  $applicationVc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $applicationVcId)
    {
        $request->validate(
            [
                'tarikh_mula' => 'required',
                'tarikh_hingga' => 'required',
                'nama_mesyuarat' => 'required',
                'room' => 'required',
                'kategori_pengerusi' => 'required',
                'bilangan_tempahan' => 'required',
            ],
            [
                'tarikh_mula.required' => 'Tarikh Mula wajib di isi',
                'tarikh_hingga.required' => 'Tarikh Hingga wajib di isi',
                'nama_mesyuarat.required' => 'Nama Mesyuarat wajib di isi',
                'room.required' => 'Bilik wajib di isi',
                'kategori_pengerusi.required' => 'Kategori Pengerusi wajib di isi',
                'bilangan_tempahan.required' => 'Bilangan Tempahan wajib di isi',
            ]
        );



        $application = Application::findOrFail($applicationVcId);

        $application->tarikh_mula = $request->tarikh_mula;
        $application->tarikh_hingga = $request->tarikh_hingga;
        $application->nama_mesyuarat = $request->nama_mesyuarat;
        $application->room_id = $request->room;
        $application->kategori_pengerusi = $request->kategori_pengerusi;
        $application->bilangan_tempahan = $request->bilangan_tempahan;
        $application->updated_at = now();
        $application->save();

        $msg = 'Maklumat Pemohonan telah dikemaskini.';
        return back()->with('successMessage', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApplicationVc  $applicationVc
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        // $count = User::whereHas('rooms', function ($q) use ($room) {
        //     $q->where('room_user.room_id', $room);
        // })->count();

        // if ($count > 0) {
        //     $msg = 'Y';
        //     return redirect('/reference/room')->with('msg', $msg);
        // } else {
        //     Room::find($room)->delete();
        //     $msg = 'Profail bilik telah dipadam.';
        //     return redirect('/reference/room')->with('successMessage', $msg);
        // }
    }
    public function result(Request $request, $batch_id)
    {
        $request->validate(
            [
                'nama_aplikasi' => 'required_if:akaun_webex,0',
                'link_webex' => 'required_if:akaun_webex,1',
                'id_webex' => 'sometimes|nullable|required_if:akaun_webex,1|email',
                'password_webex' => 'required_if:akaun_webex,1',
                'password_expired' => 'sometimes|nullable|required_if:akaun_webex,1|after:tarikh_hingga',
                'komen_ditolak' => 'required_if:button,4,5',
            ],
            [
                'nama_aplikasi.required_if' => 'Nama Aplikasi wajib di isi',
                'link_webex.required_if' => 'Link WEBEX wajib di isi',
                'id_webex.required_if' => 'ID WEBEX wajib di isi',
                'id_webex.email' => 'ID WEBEX diisi dalam format email, contoh : miti123@miti.gov.my',
                'password_webex.required_if' => 'Kata laluan WEBEX wajib di isi',
                'password_expired.required_if' => 'Tarikh luput kata laluan WEBEX wajib di isi',
                'password_expired.after' => 'Tarikh luput kata laluan mestilah selepas Tarikh Tamat Mesyuarat/Program',
                'komen_ditolak.required_if' => 'Alasan Permohonan Ditolak/Dibatalkan wajib diisi',
            ]
        );

        $supervisorVc =  User::find(Auth::id());

        $batch_id = decrypt($batch_id);

        $applications = Application::where('batch_id', $batch_id)->get();
        
        $applicationFirst = Application::where('batch_id', $batch_id)->first();

        $applicationIds = Application::where('batch_id', $batch_id)->pluck('id'); 

        // $applicationVc = ApplicationVc::where('application_id', $id)->first();

        foreach ($applicationIds as $applicationId) {

            // $status_room_id = null;
            $status_vc_id = null;

            $application = Application::find($applicationId);
            if (!$application) continue;

            $appVc = ApplicationVc::where('application_id', $applicationId)->first();
            if (!$appVc) continue;

            if ($appVc->status_vc_id == '2' || $appVc->status_vc_id == '3' || $appVc->status_vc_id == '12') {

                if ($request->button == '3') { // Lulus
                    $action_pemohon = 'diluluskan';
                    $appVc->webex = $request->akaun_webex;
                    $appVc->peralatan = $request->peralatan;
                    $appVc->catatan_penyelia = $request->catatan_vc_penyelia;

                    if ($request->akaun_webex == '1') {
                        $appVc->peralatan = $request->peralatan;
                        $appVc->link_webex = $request->link_webex;
                        $appVc->id_webex = $request->id_webex;
                        $appVc->password_webex = $request->password_webex;
                        $appVc->password_expired = $request->password_expired;
                        //remove nama_aplikasi
                        $appVc->nama_aplikasi = null;
                    } elseif ($request->akaun_webex == '0') {
                        $appVc->nama_aplikasi = $request->nama_aplikasi;
                        // remove info webex
                        $appVc->catatan_penyelia = null;
                        $appVc->link_webex = null;
                        $appVc->id_webex = null;
                        $appVc->password_webex = null;
                        $appVc->password_expired = null;
                    }

                    $attachment_vc = public_path('/references/etika_vc.jpg');
                    $msg = 'Permohonan VC telah diluluskan.';
                } elseif ($request->button == '4') { // Tolak
                    $action_pemohon = 'ditolak';
                    $appVc->komen_ditolak = $request->komen_ditolak;
                    $attachment_vc = '';
                    $msg = 'Permohonan VC telah ditolak.';
                } elseif ($request->button == '10') { // Batal
                    $action_pemohon = 'dibatalkan';
                    $appVc->komen_ditolak = $request->komen_ditolak;
                    $attachment_vc = '';
                    $msg = 'Permohonan VC telah dibatalkan.';
                } elseif ($request->button == '12') { //Lulus (Kemaskini)
                    // Get Original Data before save
                    $old_webex = $appVc->getOriginal('webex');
                    $old_peralatan = $appVc->getOriginal('peralatan');
                    $old_catatan_vc_penyelia = $appVc->getOriginal('catatan_penyelia');
                    if ($request->akaun_webex == 1) {
                        $old_link_webex = $appVc->getOriginal('link_webex');
                        $old_id_webex = $appVc->getOriginal('id_webex');
                        $old_password_webex = $appVc->getOriginal('password_webex');
                        $old_password_expired = Carbon::parse($appVc->getOriginal('password_expired'))->format('Y-m-d');

                        // Check if data was changes
                        if (
                            $old_webex != $request->akaun_webex ||
                            $old_peralatan != $request->peralatan ||
                            $old_link_webex != $request->link_webex ||
                            $old_id_webex != $request->id_webex ||
                            $old_password_webex != $request->password_webex ||
                            $old_password_expired != $request->password_expired ||
                            $old_catatan_vc_penyelia != $request->catatan_vc_penyelia
                        ) {
                            $applicationFirst->applicationVC->link_webex = $request->link_webex;
                            $applicationFirst->applicationVC->id_webex = $request->id_webex;
                            $applicationFirst->applicationVC->password_webex = $request->password_webex;
                            $applicationFirst->applicationVC->password_expired = $request->password_expired;
                            //remove nama_aplikasi
                            $applicationFirst->applicationVC->nama_aplikasi = null;
                        } else {
                            $msg = 'Tiada maklumat kemaskini dikesan.';
                            return redirect('/admin/application_vc/show/' . encrypt($batch_id))->with('errorMessage', $msg);
                        }
                    } elseif ($request->akaun_webex == 0) {
                        // return 'webex = 0';
                        $old_nama_aplikasi = $appVc->getOriginal('nama_aplikasi');

                        // Check if data was changes
                        if ($old_nama_aplikasi != $request->nama_aplikasi) {

                            $appVc->nama_aplikasi = $request->nama_aplikasi;
                            // remove info webex
                            $appVc->catatan_penyelia = null;
                            $appVc->link_webex = null;
                            $appVc->id_webex = null;
                            $appVc->password_webex = null;
                            $appVc->password_expired = null;
                        } else {
                            $msg = 'Tiada maklumat kemaskini dikesan.';
                            return redirect('/admin/application_vc/show/' . encrypt($id))->with('errorMessage', $msg);
                        }
                    }
                    $action_pemohon = 'diluluskan (Kemaskini)';
                    $appVc->webex = $request->akaun_webex;
                    $appVc->peralatan = $request->peralatan;
                    // $applicationVc->catatan_penyelia = $request->catatan_vc_penyelia;

                    $attachment_vc = public_path('/references/etika_vc.jpg');
                    $msg = 'Permohonan VC telah dikemaskini.';
                    }
                } else {
                    return redirect()->back();
                }

            
       

        // if ($applicationFirst->applicationVC->status_vc_id == '2' || $applicationFirst->applicationVC->status_vc_id == '3' || $applicationFirst->applicationVC->status_vc_id == '12') {

        //     if ($request->button == '3') { // Lulus
        //         $action_pemohon = 'diluluskan';
        //         $applicationFirst->applicationVC->webex = $request->akaun_webex;
        //         $applicationFirst->applicationVC->peralatan = $request->peralatan;
        //         $applicationFirst->applicationVC->catatan_penyelia = $request->catatan_vc_penyelia;

        //         if ($request->akaun_webex == '1') {
        //             $applicationFirst->applicationVC->peralatan = $request->peralatan;
        //             $applicationFirst->applicationVC->link_webex = $request->link_webex;
        //             $applicationFirst->applicationVC->id_webex = $request->id_webex;
        //             $applicationFirst->applicationVC->password_webex = $request->password_webex;
        //             $applicationFirst->applicationVC->password_expired = $request->password_expired;
        //             //remove nama_aplikasi
        //             $applicationFirst->applicationVC->nama_aplikasi = null;
        //         } elseif ($request->akaun_webex == '0') {
        //             $applicationFirst->applicationVC->nama_aplikasi = $request->nama_aplikasi;
        //             // remove info webex
        //             $applicationFirst->applicationVC->catatan_penyelia = null;
        //             $applicationFirst->applicationVC->link_webex = null;
        //             $applicationFirst->applicationVC->id_webex = null;
        //             $applicationFirst->applicationVC->password_webex = null;
        //             $applicationFirst->applicationVC->password_expired = null;
        //         }

        //         $attachment_vc = public_path('/references/etika_vc.jpg');
        //         $msg = 'Permohonan VC telah diluluskan.';
        //     } elseif ($request->button == '4') { // Tolak
        //         $action_pemohon = 'ditolak';
        //         $applicationFirst->applicationVC->komen_ditolak = $request->komen_ditolak;
        //         $attachment_vc = '';
        //         $msg = 'Permohonan VC telah ditolak.';
        //     } elseif ($request->button == '10') { // Batal
        //         $action_pemohon = 'dibatalkan';
        //         $applicationFirst->applicationVC->komen_ditolak = $request->komen_ditolak;
        //         $attachment_vc = '';
        //         $msg = 'Permohonan VC telah dibatalkan.';
        //     } elseif ($request->button == '12') { //Lulus (Kemaskini)
        //         // Get Original Data before save
        //         $old_webex = $applicationFirst->applicationVC->getOriginal('webex');
        //         $old_peralatan = $applicationFirst->applicationVC->getOriginal('peralatan');
        //         $old_catatan_vc_penyelia = $applicationFirst->applicationVC->getOriginal('catatan_penyelia');
        //         if ($request->akaun_webex == 1) {
        //             $old_link_webex = $applicationFirst->applicationVC->getOriginal('link_webex');
        //             $old_id_webex = $applicationFirst->applicationVC->getOriginal('id_webex');
        //             $old_password_webex = $applicationFirst->applicationVC->getOriginal('password_webex');
        //             $old_password_expired = Carbon::parse($applicationFirst->applicationVC->getOriginal('password_expired'))->format('Y-m-d');

        //             // Check if data was changes
        //             if (
        //                 $old_webex != $request->akaun_webex ||
        //                 $old_peralatan != $request->peralatan ||
        //                 $old_link_webex != $request->link_webex ||
        //                 $old_id_webex != $request->id_webex ||
        //                 $old_password_webex != $request->password_webex ||
        //                 $old_password_expired != $request->password_expired ||
        //                 $old_catatan_vc_penyelia != $request->catatan_vc_penyelia
        //             ) {
        //                 $applicationFirst->applicationVC->link_webex = $request->link_webex;
        //                 $applicationFirst->applicationVC->id_webex = $request->id_webex;
        //                 $applicationFirst->applicationVC->password_webex = $request->password_webex;
        //                 $applicationFirst->applicationVC->password_expired = $request->password_expired;
        //                 //remove nama_aplikasi
        //                 $applicationFirst->applicationVC->nama_aplikasi = null;
        //             } else {
        //                 $msg = 'Tiada maklumat kemaskini dikesan.';
        //                 return redirect('/admin/application_vc/show/' . encrypt($batch_id))->with('errorMessage', $msg);
        //             }
        //         } elseif ($request->akaun_webex == 0) {
        //             // return 'webex = 0';
        //             $old_nama_aplikasi = $applicationFirst->applicationVC->getOriginal('nama_aplikasi');

        //             // Check if data was changes
        //             if ($old_nama_aplikasi != $request->nama_aplikasi) {

        //                 $applicationFirst->applicationVC->nama_aplikasi = $request->nama_aplikasi;
        //                 // remove info webex
        //                 $applicationFirst->applicationVC->catatan_penyelia = null;
        //                 $applicationFirst->applicationVC->link_webex = null;
        //                 $applicationFirst->applicationVC->id_webex = null;
        //                 $applicationFirst->applicationVC->password_webex = null;
        //                 $applicationFirst->applicationVC->password_expired = null;
        //             } else {
        //                 $msg = 'Tiada maklumat kemaskini dikesan.';
        //                 return redirect('/admin/application_vc/show/' . encrypt($id))->with('errorMessage', $msg);
        //             }
        //         }
        //         $action_pemohon = 'diluluskan (Kemaskini)';
        //         $applicationFirst->applicationVC->webex = $request->akaun_webex;
        //         $applicationFirst->applicationVC->peralatan = $request->peralatan;
        //         // $applicationVc->catatan_penyelia = $request->catatan_vc_penyelia;

        //         $attachment_vc = public_path('/references/etika_vc.jpg');
        //         $msg = 'Permohonan VC telah dikemaskini.';
        //     }
        // } else {
        //     return redirect()->back();
        // }

            $appVc->status_vc_id = $request->button;
            $appVc->catatan_penyelia = $request->catatan_vc_penyelia;

            if (!$appVc->status_vc_id) continue; 

            // $dataVc = [
            //     'status_room_id' => $status_vc_id,
            //     'action_by' => $supervisorVc->id,
            //     'catatan_penyelia' => $request->catatan_penyelia,
            //     'tarikh_keputusan' => now(),
            // ];

            // $appVc->update($dataVc);

            $appVc->save();
        }

        if ($applicationFirst->applicationVc->status_vc_id == '4') { // Tolak
            $vc_komen_ditolak = $applicationFirst->applicationVc->komen_ditolak;
        }else{
             $vc_komen_ditolak = '';
        }

        $nama_pengerusi = $application->nama_pengerusi ?? $application->kategori_pengerusi;

        $status_bilik = '';
        $status_bilik_id = '';
        $catatan_room = '';
        $catatan_room_penyelia = '';

        if (!empty($application->applicationRoom)) {
            $status_bilik = $applicationFirst->applicationRoom->statusRoom->status_pemohon;
            $status_bilik_id = $applicationFirst->applicationRoom->status_room_id;
            $catatan_room = $applicationFirst->applicationRoom->catatan;
            $catatan_room_penyelia = $applicationFirst->applicationRoom->catatan_penyelia;
        }

        if (!empty($applicationFirst->applicationVc)) {
            $apply_vc = 1;
            $status_vc_id = $appVc->status_vc_id;

            $webex = $appVc->webex;
            $link_webex = '';
            $id_webex = '';
            $password_webex = '';
            $password_expired = '';
            $catatan_vc = '';


            $nama_aplikasi = '';

            $peralatan = $appVc->peralatan;

            if ($peralatan == 1) {
                $peralatan = 'YA';
            } else {
                $peralatan = 'TIDAK';
            }

            if ($webex == 1) {
                $webex = 'YA';
                $link_webex = $appVc->link_webex;
                $id_webex = $appVc->id_webex;
                $password_webex = $appVc->password_webex;
                $password_expired = date('d-m-Y g:i A', strtotime($appVc->password_expired));
            } else {
                $webex = 'TIDAK';
                $nama_aplikasi = $appVc->nama_aplikasi;
            }
            $catatan_vc = $appVc->catatan;
            $catatan_penyelia_vc = $appVc->catatan_penyelia;
        } else {
            $apply_vc = 0;
            $status_vc_id = '';
        }

        //Collect date
            $tarikh_list = [];

            foreach ($applications as $app) {
                $carbon_mula = \Carbon\Carbon::parse($app->tarikh_mula);
                $carbon_hingga = \Carbon\Carbon::parse($app->tarikh_hingga);

                $tarikh_list[] = [
                    'tarikh_mula' => $carbon_mula->format('d/m/Y'),
                    'tarikh_hingga' => $carbon_hingga->format('d/m/Y'),
                    'masa_mula' => $carbon_mula->format('g:i A'),
                    'masa_hingga' => $carbon_hingga->format('g:i A'),
                ];
            }

            $senarai_tarikh = $tarikh_list;
        //End Collect date      

        $data = array(
            'to_pemohon' => $application->user->email,
            'tempahan' => 'VC',
            'action_pemohon' => $action_pemohon,
            'subject_pemohon' => 'Makluman: Permohonan Tempahan VC di ' . $application->room->nama .' '. $action_pemohon,
            'action_penyelia2' => '',
            'id' => $application->id,
            'batch_id' => $application->batch_id,
            'nama_pemohon' => $application->user->name,
            'bahagian_pemohon' => $application->user->profile->department->nama,
            'nama_mesyuarat' => $application->nama_mesyuarat,
            'bilik' => $application->room->nama,          
            'senarai_tarikh' => $senarai_tarikh,
            'nama_pengerusi' => $nama_pengerusi,
            'bilangan_tempahan' => $application->bilangan_tempahan,
            'catatan_room' => $catatan_room,
            'catatan_room_penyelia' => $catatan_room_penyelia,
            'status_bilik' => $status_bilik,
            'status_bilik_id' => $status_bilik_id,
            'apply_vc' => $apply_vc,
            'status_vc_id' => $status_vc_id,
            'status_vc' => $application->applicationVc->statusVc->status_pemohon,
            'link_webex' => $link_webex,
            'id_webex' => $id_webex,
            'password_webex' => $password_webex,
            'password_expired' => $password_expired,
            'catatan_penyelia_vc' => $catatan_penyelia_vc,
            'webex' => $webex,
            'peralatan' => $peralatan,
            'nama_aplikasi' => $nama_aplikasi,
            'catatan_vc' => $catatan_vc,
            'attachment_vc' => $attachment_vc,
            'vc_komen_ditolak' => $vc_komen_ditolak,
        );

        if ($request->button == '3' || $request->button == '12') {

            Mail::send(['html' => 'emails.pemohon'], $data, function ($message) use ($data) {
                $message->subject($data['subject_pemohon']);
                $message->to($data['to_pemohon']);
                $message->cc(['urki@miti.gov.my']);
                $message->from('eTempah@miti.gov.my', "eTempah");
                $message->attach($data['attachment_vc']);
            });
        } else {

            Mail::send(['html' => 'emails.pemohon'], $data, function ($message) use ($data) {
                $message->subject($data['subject_pemohon']);
                $message->to($data['to_pemohon']);
                $message->from('eTempah@miti.gov.my', "eTempah");
            });
        }

        return redirect('/admin/application_vc/show/' . encrypt($application->id))->with('successMessage', $msg);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationRoom;
use App\Models\ApplicationVc;
use App\Models\Department;
use App\Models\Position;
use App\Models\Profile;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApplicationRoomController extends Controller
{

    public function index($status)
    {
        $user = User::where('is_admin', 1)
            ->where('id', Auth::user()->id)
            ->first();

        $user_id = $user->id ?? '';

        $role = $user->getRoleNames();

         if ($role == 'super-admin') {
            $rooms = Room::pluck('id')->toArray(); // ambil semua bilik
        } else {
            //bilik penyelia
            $rooms = Room::whereHas('users', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->pluck('id')->toArray();
        }

        if ($status == '1') { // Tindakan
            $statuses = ['1', '3'];
        } elseif ($status == '2') { //Rekod
            $statuses = ['2', '4', '5', '6', '7', '11', '12', '13', '14'];
        } elseif ($status == '3') { //Jumlah permohonan
            $statuses = ['1', '2', '3', '4', '5', '6', '7', '11', '12', '13', '14'];
        } elseif ($status == '4') { //Baru
            $statuses = ['1'];
        } elseif ($status == '5') { //Dalam Proses
            $statuses = ['3'];
        } elseif ($status == '6') { //Selesai
            $statuses = ['2', '4', '5', '6', '7', '11', '12', '13', '14'];
        }

        if ($status == 1) {
            $tajuk = 'Tindakan Tempahan Bilik';
        } elseif ($status == 2 || $status == 3 || $status == 6) {
            $tajuk = 'Rekod Tempahan Bilik';
        }

        $batches = Application::with(['applicationRoom.statusRoom', 'room'])
            ->whereBetween('tarikh_mula', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->whereHas('applicationRoom', function ($q) use ($statuses) {
                $q->whereIn('status_room_id', $statuses);
            })
            ->whereIn('room_id', $rooms)
            ->orderBy('tarikh_mula')
            ->get()
            ->groupBy('batch_id');

        return view('admins.room_approve.index', compact('batches', 'tajuk'));
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

    public function store(Request $request)
    {
        //
    }

    public function show($application)
    {
        $departments = Department::orderBy('nama', 'ASC')->get();

        $positions = Position::orderBy('nama', 'ASC')->get();

        $rooms = Room::orderBy('nama', 'ASC')->get();

        $id = Auth::id();

        $user = User::where('id', $id)->first();

        $profile = Profile::where('user_id', $id)->first();

        $application = Application::findOrFail(decrypt($application));

        $applications = Application::where('batch_id', $application->batch_id)->get();

        $tarikh_mula = Carbon::parse($application->tarikh_mula)->format('Y-m-d H:i:s');
        $toTime_new = Carbon::parse($tarikh_mula)->format('H:i:s');

        $tarikh_hingga = Carbon::parse($application->tarikh_hingga)->format('Y-m-d H:i:s');
        $fromTime_new = Carbon::parse($tarikh_hingga)->format('H:i:s');
        //end new data

        $application_exist = Application::join('application_rooms', 'applications.id', '=', 'application_rooms.application_id')
            ->where('tarikh_hingga', '>', $application->tarikh_mula)
            ->where('tarikh_mula', '<', $application->tarikh_hingga)
            ->where('room_id', $application->room_id)
            ->whereIn('status_room_id', ['2', '6', '11', '14'])->first();

        $applicationCount = 0;

        if ($application_exist) {
            $toDate = Carbon::parse($application_exist->tarikh_hingga);
            $fromDate = Carbon::parse($application_exist->tarikh_mula);
            $toTime = Carbon::parse($application_exist->tarikh_hingga)->format('H:i:s');
            $fromTime = Carbon::parse($application_exist->tarikh_mula)->format('H:i:s');
            $diffDays = $toDate->diffInDays($fromDate);

            if ($diffDays > 0) { //redundant dgn daterange lebih 1 hari
                // return '> 1 days';
                if ($toTime >= $toTime_new && $fromTime <= $fromTime_new) {
                    // return 'redundancy';
                    $applicationCount = $diffDays;
                } else {
                    $applicationCount = 0;
                }
            } else { //redundant dgn daterange 1 hari
                // return '1 Days';
                $applicationCount = Application::join('application_rooms', 'applications.id', '=', 'application_rooms.application_id')
                    ->where('tarikh_hingga', '>=', $tarikh_mula)
                    ->where('tarikh_mula', '<=', $tarikh_hingga)
                    ->where('room_id', $application->room_id)
                    ->whereIn('status_room_id', ['2', '6', '14'])
                    ->count();
            }
        }

        return view('admins.room_approve.view', compact('application','applications', 'departments', 'rooms', 'positions', 'user', 'profile', 'applicationCount'));
    }

    public function edit($applicationRoomId)
    {
        // return decrypt($applicationRoomId);
        $contains = 1;
        $applicationRoomId = decrypt($applicationRoomId);
        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();
        // $application = Application::where('batch_id', $applicationRoomId)->first();
        $applications = Application::where('batch_id', $applicationRoomId)->get();
        $application = $applications->first();
        $room = $application->applicationRoom;
        $bookings = [];

        foreach ($applications as $application) {
            if ($application->tarikh_mula && $application->tarikh_hingga) {
                $bookings[] = [
                    'id'    => $application->id,
                    'batch_id'    => $application->batch_id,
                    'status_room_id'    => $application->status_room_id,
                    'status_room_name'    => $application->applicationRoom->statusRoom->status_pentadbiran,
                    'start' => \Carbon\Carbon::parse($application->tarikh_mula)->format('d/m/Y H:i'),
                    'end'   => \Carbon\Carbon::parse($application->tarikh_hingga)->format('d/m/Y H:i'),
                ];
            }
        }

        $department = $application->user->profile->department_id;
        $user =  User::find(Auth::id());

        //List Bilik mengikut departmen, Hanya bilik yg mempunyai penyelia sahaja
        $rooms = Room::whereHas('departments', function ($q) use ($department) {
            $q->where('department_id', $department);
        })->get();

        $applicationCount = Application::join('application_rooms', 'applications.id', '=', 'application_rooms.application_id')
            ->where('tarikh_hingga', '>', $application->tarikh_mula)
            ->where('tarikh_mula', '<', $application->tarikh_hingga)
            ->where('room_id', $application->room_id)
            ->whereIn('status_room_id', ['2', '6', '11', '14'])->count();

        return view('admins.room_approve.edit_approve', compact('applications','application', 'bookings', 'departments', 'rooms', 'positions', 'applicationCount','user','contains'));
    }

    public function update(Request $request, $batch_id)
    {
        // dd('sini');
        $applications = Application::where('batch_id',$batch_id)->get();
        $application = Application::where('batch_id',$batch_id)->first();
        $id = Auth::id();
        if ($application->applicationRoom->status_room_id == '1') {

            foreach($applications as $batches){

                $tarikh_list = [];

                $carbon_mula = \Carbon\Carbon::parse($batches->tarikh_mula);
                $carbon_hingga = \Carbon\Carbon::parse($batches->tarikh_hingga);

                $tarikh_list[] = [
                    'tarikh_mula' => $carbon_mula->format('d/m/Y'),
                    'tarikh_hingga' => $carbon_hingga->format('d/m/Y'),
                    'masa_mula' => $carbon_mula->format('g:i A'),
                    'masa_hingga' => $carbon_hingga->format('g:i A'),
                ];

                $senarai_tarikh = $tarikh_list;
                $batches->bilangan_tempahan = $request->bilangan_tempahan;
                $batches->updated_at = now();
                $batches->updated_by = $id;

                // Get Original Data before save
                $old_bilangan_tempahan = $batches->getOriginal('bilangan_tempahan');

                //Tujuan supaya kalau ada changes baru tukar status = 14
                if ($old_bilangan_tempahan != $batches->bilangan_tempahan) {

                    $batches->applicationRoom->status_room_id = '14'; //Lulus dengan pindaan
                    $batches->applicationRoom->catatan_penyelia = $request->catatan_room_penyelia;

                    //update status vc -> Dalam Proses
                    if (!empty($batches->applicationVc)) {
                        $batches->applicationVc->status_vc_id = '2';
                        $batches->applicationVc->save();
                    }
                }else{
                    return back()->with('mesej','Tiada perubahan');
                }
                $batches->applicationRoom->save();
                $batches->save();
            }

            $email_penyeliaVc = User::role('approver-vc')->pluck('email')->toArray();

            $webex = '';
            $nama_aplikasi = '';
            $link_webex = '';
            $id_webex = '';
            $password_webex = '';
            $password_expired = '';
            $apply_vc = '';
            $status_vc_id = '';
            $status_vc = '';
            $catatan_vc = '';
            $catatan_penyelia_vc = '';
            $action_penyelia_vc = '';
            $action_pemohon = 'diluluskan dengan pindaan';
            $action_pemohon_vc = '';
            $main_action = '';
            $action_penyelia2 = '';
            $peralatan = '';

            if (!empty($application->applicationVc)) {
                $status_vc_id = $application->applicationVc->status_vc_id;
                $catatan_vc = $application->applicationVc->catatan;
                $catatan_penyelia_vc = $application->applicationVc->catatan_penyelia;
                $webex = $application->applicationVc->webex;
                $apply_vc = '1';
                $status_vc = $application->applicationVc->statusVc->status_pemohon; //untuk pindaan, sebelum ni comment
                $peralatan = $application->applicationVc->peralatan;

                if ($peralatan == 1) {
                    $peralatan = 'YA';
                } else {
                    $peralatan = 'TIDAK';
                }

                if ($webex == 1) {
                    $webex = 'YA';
                    $nama_aplikasi = '';
                    $link_webex = $application->applicationVc->link_webex;
                    $id_webex = $application->applicationVc->id_webex;
                    $password_webex = $application->applicationVc->password_webex;
                    $password_expired = date('d-m-Y g:i A', strtotime($application->applicationVc->password_expired));
                } else {
                    $webex = 'TIDAK';
                    $nama_aplikasi = $application->applicationVc->nama_aplikasi;
                }
            }

            $data = array(
                'to_pemohon' => $application->user->email,
                'tempahan' => 'bilik',
                'to_penyelia_vc' => $email_penyeliaVc,
                'subject_pemohon' => 'Makluman: Permohonan ' . ucwords(strtolower($action_penyelia2)) . ' Tempahan ' . $application->room->nama,
                'subject_penyelia_vc' => 'Tindakan: Permohonan Baru Tempahan VC di ' . $application->room->nama,
                'action_pemohon' => $action_pemohon,
                'action_penyelia2' => $action_penyelia2,
                'action_penyelia_vc' => 'untuk tindakan',
                'id' => $application->id,
                'batch_id' => $application->batch_id,
                'nama_pemohon' => $application->user->name,
                'senarai_tarikh' => $senarai_tarikh,
                'bahagian_pemohon' => $application->user->profile->department->nama,
                'nama_mesyuarat' => $application->nama_mesyuarat,
                'bilik' => $application->room->nama,
                'status_bilik' => $application->applicationRoom->statusRoom->status_pemohon,
                'status_bilik_id' => $application->applicationRoom->status_room_id,
                'nama_pengerusi' => $application->nama_pengerusi,
                'bilangan_tempahan' => $application->bilangan_tempahan,
                'catatan_room' => $application->applicationRoom->catatan,
                'catatan_room_penyelia' => $application->applicationRoom->catatan_penyelia,
                'apply_vc' => $apply_vc,
                'status_vc_id' => $status_vc_id,
                'status_vc' => $status_vc,
                'peralatan' => $peralatan,
                // 'status_vc' => $applicationRoom->application->applicationVc->statusVc->status_pemohon,
                'link_webex' => $link_webex,
                'id_webex' => $id_webex,
                'password_webex' => $password_webex,
                'password_expired' => $password_expired,
                // 'catatan_penyelia_vc' => $applicationRoom->application->applicationVc->catatan_penyelia,
                'catatan_penyelia_vc' => $catatan_penyelia_vc,
                'webex' => $webex,
                'nama_aplikasi' => $nama_aplikasi,
                'catatan_vc' => $catatan_vc,
                'vc_komen_ditolak' => '',
            );

            if (!empty($applicationRoom->application->applicationVc)) {
                if ($application->applicationRoom->status_room_id == '14') {
                    //bila penyelia bilik luluskan bilik, status vc akan bertukar kepada dalam proses.  So email perlu dihantar kpd penyelia vc.
                    Mail::send(['html' => 'emails.penyelia_vc'], $data, function ($message) use ($data) {
                        $message->subject($data['subject_penyelia_vc']);
                        $message->to($data['to_penyelia_vc']);
                        $message->from('eTempah@miti.gov.my', "eTempah");
                    });
                }
            }

            Mail::send(
                ['html' => 'emails.pemohon'],
                $data,
                function ($message) use ($data) {
                    $message->subject($data['subject_pemohon']);
                    $message->to($data['to_pemohon']);
                    $message->from('eTempah@miti.gov.my', "eTempah");
                }
            );

            $msg = 'Permohonan telah berjaya dipinda dan diluluskan.';
            return redirect('/admin/application_room/show/' . encrypt($application->applicationRoom->application_id))->with('successMessage', $msg);
        } else {
            $msg = 'Lulus Dengan Pindaan Tidak Berjaya (Perlu pindaan bilangan tempahan).';
            return redirect('/admin/application_room/show/' . encrypt($application->applicationRoom->application->batch_id))->with('errorMessage', $msg);
        }

    }

    public function edit_pantry($applicationRoomId)
    {
        $applicationRoomId = decrypt($applicationRoomId);
        $application = Application::where('id', $applicationRoomId)->first();
        return view('admins.room_approve.edit_pantry', compact('application'));
    }

    public function update_pantry(Request $request, $applicationRom)
    {
        $applicationRoom = ApplicationRoom::where('application_id', $applicationRom)->first();
        $id = Auth::id();

        $applicationRoom->application->bilangan_tempahan = $request->bilangan_tempahan;
        $applicationRoom->application->save();

        $applicationRoom->sajian = $request->sajian;

        // if ($request->minum_pagi == 'on') {
        //     $minum_pagi = '1';
        // } else {
        //     $minum_pagi = '';
        // }

        // if ($request->makan_tengahari == 'on') {
        //     $makan_tengahari = '1';
        // } else {
        //     $makan_tengahari = '';
        // }

        // if ($request->minum_petang == 'on') {
        //     $minum_petang = '1';
        // } else {
        //     $minum_petang = '1';
        // }

        // Untuk padam maklumat yang tiada kaitan dengan pilihan sajian
        if ($request->sajian == 'Tidak Perlu') {
            $applicationRoom->minum_pagi = '';
            $applicationRoom->makan_tengahari = '';
            $applicationRoom->minum_petang = '';
        } elseif ($request->sajian == 'Pantri Dalaman') {
            $applicationRoom->minum_pagi = $request->minum_pagi;
            $applicationRoom->makan_tengahari = '';
            $applicationRoom->minum_petang = $request->minum_petang;
        } elseif ($request->sajian == 'Katerer Luar') {
            $applicationRoom->minum_pagi = $request->minum_pagi;
            $applicationRoom->makan_tengahari = $request->makan_tengahari;
            $applicationRoom->minum_petang = $request->minum_petang;
        }

        $applicationRoom->created_at = now();
        $applicationRoom->created_by = $id;

        $applicationRoom->save();

        $msg = 'Maklumat telah dikemaskini.';
        return redirect('/admin/application_room/edit_pantry/' . encrypt($applicationRoom->application_id))->with('successMessage', $msg);
    }

    public function result(Request $request, $batch_id)
    {
        // return $request->button;

        $supervisorRoom =  User::find(Auth::id());

        $email_penyeliaVc = User::role('approver-vc')->pluck('email')->toArray();

        $applications = Application::where('batch_id', $batch_id)->get();

        $applicationFirst = Application::where('batch_id', $batch_id)->first();

        $applicationIds = Application::where('batch_id', $batch_id)->pluck('id');

        $roomId = $applicationFirst->room_id;

        // $room_users = Room::find($roomId)->users;

        foreach ($applicationIds as $applicationId) {

            $status_room_id = null;
            $status_vc_id = null;

            $application = Application::find($applicationId);
            if (!$application) continue;

            $appRoom = ApplicationRoom::where('application_id', $applicationId)->first();
            if (!$appRoom) continue;

            // Status semasa = Baru (1)
            if ($appRoom->status_room_id == '1') {

                if ($request->button == '2') { // Lulus
                    $status_room_id = '2';
                    $status_vc_id = '2';
                }

                if ($request->button == '4') { // Tolak
                    $status_room_id = '4';
                    $status_vc_id = '4';
                }

                if ($request->button == '13') { // Batal oleh pentadbir
                    $status_room_id = '13';
                    $status_vc_id = '11';
                }

                if ($request->button == '7') { // Batal oleh pemohon -> tiada perubahan kpd VC kerana status VC masih draf
                    $status_room_id = '7';
                    $status_vc_id = '5';
                }

                $appRoom->catatan_penyelia = $request->catatan_room_penyelia;
            }

            // Status semasa = Lulus (2)
            if ($appRoom->status_room_id == '2' || $appRoom->status_room_id == '14') { //Lulus & Lulus dengan Pindaan
                // return 'batal oleh pentadbir 2';

                if ($request->button == '12')// Batal oleh Pentadbir selepas lulus
                {
                    $status_room_id = '12';
                    $status_vc_id = '11';
                }
            }

            // Status semasa = Menunggu keputusan pembatalan (3)
            if ($appRoom->status_room_id == '3') {

                if ($request->button == '5') { // Lulus pembatalan
                    $status_room_id = '5';
                    $status_vc_id = '5';
                }

                if ($request->button == '6') { // Tolak pembatalan
                    $status_room_id = '6';
                    $status_vc_id = $application->applicationVc?->status_vc_id;
                }
            }

            //Status (4 = Tolak, 5 = Lulus Pembatalan, 6 = Ditolak Pembatalan (Lulus), 7 = Batal oleh Pemohon, 12 = Batal oleh Pentadbir selepas kelulusan,13 = Batal oleh Pentadbir sebelum kelulusan)-> end of action by Approver

            if (!$status_room_id) continue;

            $dataRoom = [
                'status_room_id' => $status_room_id,
                'action_by' => $supervisorRoom->id,
                'catatan_penyelia' => $request->catatan_room_penyelia,
                'tarikh_keputusan' => now(),
            ];

            if (in_array($request->button, ['4','12', '13'])) {
                $dataRoom['komen_ditolak'] = $request->komen_ditolak;
            }

            if (in_array($status_room_id, ['13', '7'])) {
                $dataRoom['tarikh_batal'] = now();
            }

            $appRoom->update($dataRoom);

            $appVc = ApplicationVc::where('application_id', $applicationId)->first();
            if (!$appVc) continue;

            // if (!$status_vc_id) continue;

            $dataVc = [
                'status_vc_id' => $status_vc_id,
                'action_by' => $supervisorRoom->id,
                'catatan_penyelia' => $request->catatan_room_penyelia,
                'tarikh_keputusan' => now(),
            ];

            $appVc->update($dataVc);
        }
        // return $applicationFirst->applicationRoom->status_room_id;

        // Assign ApplicationRoom data for email content
        $komen_ditolak = null;
        if ($applicationFirst->applicationRoom->status_room_id == '2') { //Lulus
            $msg = 'Permohonan telah diluluskan.';
            $action_pemohon = 'diluluskan';
        }

        if ($applicationFirst->applicationRoom->status_room_id == '3') { //Permohonan Pembatalan
        }

        if ($applicationFirst->applicationRoom->status_room_id == '4') { //Tolak
            $msg = 'Permohonan telah ditolak.';
            $action_pemohon = 'ditolak';
            $komen_ditolak = $appRoom->komen_ditolak;
        }

        if ($applicationFirst->applicationRoom->status_room_id == '5') { //Lulus Pembatalan
            $msg = 'Permohonan pembatalan telah diluluskan (Permohonan status BATAL).';
            $action_pemohon = 'diluluskan';
            //Maksudnya status Batal dan ada dalam kalendar
        }

        if ($applicationFirst->applicationRoom->status_room_id == '6') { //Tolak Pembatalan
            $msg = 'Permohonan pembatalan tidak diluluskan (Permohonan kekal status LULUS).';
            $action_pemohon = 'ditolak';
            //Maksudnya status masih lulus dan ada dalam kalendar
        }

        if ($applicationFirst->applicationRoom->status_room_id == '7') { // Pemohon membuat pembatalan permohonan Baru
            $msg = 'Permohonan telah dibatalkan.';
            $action_pemohon = 'dibatalkan oleh Pentadbir';
        }

        if ($applicationFirst->applicationRoom->status_room_id == '12') { // Batal oleh pentadbir selepas kelulusan
            $action_pemohon = 'dibatalkan oleh Pentadbir';
            $msg = 'Permohonan telah dibatalkan.';
            $komen_ditolak = $application->applicationRoom->komen_ditolak;
        }

        if ($applicationFirst->applicationRoom->status_room_id == '13') { // Batal oleh pentadbir terhadap permohonan Baru
            $action_pemohon = 'dibatalkan oleh Pentadbir (permohonan baru)';
            $msg = 'Permohonan telah dibatalkan.';
            $komen_ditolak = $application->applicationRoom->komen_ditolak;
        }

        $nama_pengerusi = $application->nama_pengerusi ?? $application->kategori_pengerusi;

        //close for email content ApplicationRoom
        if($applicationFirst->applicationRoom->status_room_id == '5' || $applicationFirst->applicationRoom->status_room_id == '6'){
            $action_penyelia2 = 'pembatalan';
        }else{
            $action_penyelia2 = '';
        }

        $vcData = [
            'webex' => '',
            'peralatan' => '',
            'nama_aplikasi' => '',
            'link_webex' => '',
            'id_webex' => '',
            'password_webex' => '',
            'password_expired' => '',
            'apply_vc' => '',
            'status_vc_id' => '',
            'status_vc' => '',
            'catatan_vc' => '',
            'catatan_penyelia_vc' => '',
            'action_penyelia_vc' => '',
            'main_action' => '',
            'note' => '',
            'vc_komen_ditolak' => '',
        ];

        extract($vcData);

        $vc = $applicationFirst->applicationVc ?? null;

        if ($vc) {
            $status_vc_id = $vc->status_vc_id;
            $status_vc = $vc->statusVc->status_pemohon;
            $catatan_vc = $vc->catatan;
            $catatan_penyelia_vc = $vc->catatan_penyelia;
            $webex = $vc->webex == 1 ? 'YA' : 'TIDAK';
            $peralatan = $vc->peralatan == 1 ? 'YA' : 'TIDAK';
            $apply_vc = '1';

            if ($webex === 'YA') {
                $nama_aplikasi = '';
                $link_webex = $vc->link_webex;
                $id_webex = $vc->id_webex;
                $password_webex = $vc->password_webex;
                $password_expired = date('d-m-Y g:i A', strtotime($vc->password_expired));
            } else {
                $nama_aplikasi = $vc->nama_aplikasi;
            }

            // Komen ditolak jika bilik ditolak
            $vc_komen_ditolak = $vc->komen_ditolak;
            if ($application->applicationRoom->status_room_id == 4 && is_null($vc_komen_ditolak)) {
                $note = '(kerana permohonan bilik telah ditolak)';
            } else {
                $vc_komen_ditolak = '';
            }

            // Email VC
            if (in_array($request->button, ['2', '4', '13', '12']) || in_array($request->button5, ['5']) || in_array($request->button6, ['6'])) {
                $vc->action_by = $supervisorRoom->id;

                if ($request->button == '2') {
                    // $vc->status_vc_id = '2';
                    $main_action = 'Tindakan';
                    $action_penyelia_vc = 'untuk tindakan';
                } elseif ($request->button == '4') {
                    // $vc->status_vc_id = '4';
                    $action_pemohon = 'ditolak';
                } elseif (in_array($request->button, ['13', '12'])) {
                    if ($application->applicationRoom->status_room_id == '1') {
                        // $vc->status_vc_id = '11';
                    } elseif (in_array($application->applicationRoom->status_room_id, ['2', '12'])) {
                        // $vc->status_vc_id = '10';
                    } elseif ($application->applicationRoom->status_room_id == '13') {
                        // $vc_status = $vc->status_vc_id;
                        $vc->status_vc_id = in_array($vc->status_vc_id, ['1', '2']) ? '11' : ($vc->status_vc_id == '3' ? '10' : $vc->status_vc_id);
                        $main_action = 'Makluman';
                        $action_penyelia_vc = 'dibatalkan oleh Pentadbir Bilik';
                    }
                }

                // Pembatalan: Kekalkan status, hanya rekod action_by
                if ($request->button5 == '5' || $request->button6 == '6') {
                    // Kekalkan status_vc_id
                }

                $vc->tarikh_keputusan = now();
                $vc->save();

                $status_vc = $vc->statusVc->status_pemohon ?? '-';
            }
        }

        $tempahan = !empty($application->applicationRoom) && !empty($application->applicationVc)
        ? 'bilik & VC'
        : (!empty($application->applicationRoom)
        ? 'bilik'
        : (!empty($application->applicationVc) ? 'VC' : '-'));

        //VC - tak loop sebab tak sepatutnya wujud data yang tidak sama (kecuali tarikh mula & tarikh hingga)
        if (!empty($applicationFirst->applicationVc)) {

            $status_vc_id = $applicationFirst->applicationVc->status_vc_id;
            $catatan_vc = $applicationFirst->applicationVc->catatan;
            $catatan_penyelia_vc = $applicationFirst->applicationVc->catatan_penyelia;
            $webex = $applicationFirst->applicationVc->webex;
            $apply_vc = '1';
            $peralatan = $applicationFirst->applicationVc->peralatan;

            $peralatan = $peralatan == 1 ? 'YA' : 'TIDAK';

            if ($webex == 1) {
                $webex = 'YA';
                $nama_aplikasi = '';
                $link_webex = $applicationFirst->applicationVc->link_webex;
                $id_webex = $applicationFirst->applicationVc->id_webex;
                $password_webex = $applicationFirst->applicationVc->password_webex;
                $password_expired = date('d-m-Y g:i A', strtotime($applicationFirst->applicationVc->password_expired));
            } else {
                $webex = 'TIDAK';
                $nama_aplikasi = $applicationFirst->applicationVc->nama_aplikasi;
            }

            $vc_komen_ditolak = $applicationFirst->applicationVc->komen_ditolak;
                if ($applicationFirst->applicationRoom->status_room_id == 4 && is_null($applicationFirst->applicationVc->komen_ditolak)){
                    $note = '(kerana permohonan bilik telah ditolak)';
                }
        }

        // Ditambah untuk CR pada 7 Jun 2024
        // nota : Jika status bilik = 4 (tolak), Status VC = '-'

        if (!empty($application->applicationVc)) {

            $vc_komen_ditolak = $application->applicationVc->komen_ditolak;

            if ($application->applicationRoom->status_room_id == 4 && is_null($application->applicationVc->komen_ditolak)){
                $note = '(kerana permohonan bilik telah ditolak)';
                }else{
                    $vc_komen_ditolak = '';
                }
            }
        else{
            $vc_komen_ditolak = null;
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
                'tempahan' => $tempahan,
                'to_penyelia_vc' => $email_penyeliaVc,
                'subject_pemohon' => 'Makluman: Permohonan ' . ucwords(strtolower($action_penyelia2)) . ' Tempahan ' . $tempahan . ' di ' . $application->room->nama . ' '.$action_pemohon,
                'subject_pemohon' => 'Makluman: Permohonan ' . ucwords(strtolower($action_penyelia2)) . ' Tempahan ' . $tempahan . ' di ' . $application->room->nama,
                'subject_penyelia_vc' => 'Makluman : Permohonan Baru Tempahan VC di ' . $application->room->nama . $action_penyelia_vc,
                'tarikh_list' => $tarikh_list,
                'subject_penyelia_vc' => 'Makluman : Permohonan Baru Tempahan VC di ' . $application->room->nama, ''. $action_penyelia_vc,
                'action_pemohon' => $action_pemohon,
                'action_penyelia2' => $action_penyelia2,
                'action_penyelia_vc' => $action_penyelia_vc,
                'id' => $application->id,
                'batch_id' => $application->batch_id,
                'nama_pemohon' => $application->user->name,
                'bahagian_pemohon' => $application->user->profile->department->nama,
                'nama_mesyuarat' => $application->nama_mesyuarat,
                'bilik' => $application->room->nama,
                'status_bilik' => $application->applicationRoom->statusRoom->status_pemohon,
                'status_bilik_id' => $application->applicationRoom->status_room_id,
                'komen_ditolak' => $komen_ditolak,
                'senarai_tarikh' => $senarai_tarikh,
                'nama_pengerusi' => $nama_pengerusi,
                'bilangan_tempahan' => $application->bilangan_tempahan,
                'catatan_room' => $application->applicationRoom->catatan,
                'catatan_room_penyelia' => $application->applicationRoom->catatan_penyelia,
                'apply_vc' => $apply_vc,
                'status_vc_id' => $status_vc_id,
                'status_vc' => $status_vc,
                'link_webex' => $link_webex,
                'id_webex' => $id_webex,
                'password_webex' => $password_webex,
                'password_expired' => $password_expired,
                'catatan_penyelia_vc' => $catatan_penyelia_vc,
                'webex' => $webex,
                'peralatan' => $peralatan,
                'nama_aplikasi' => $nama_aplikasi,
                'catatan_vc' => $catatan_vc,
                'note' => $note,
                'vc_komen_ditolak' => $vc_komen_ditolak,
            );

        if (!empty($application->applicationVc)) {
            if ($request->button == '2' || $application->applicationRoom->status_room_id == '13') {
                //bila penyelia bilik luluskan bilik, status vc akan bertukar kepada dalam proses.  So email perlu dihantar kpd penyelia vc.
                Mail::send(['html' => 'emails.penyelia_vc'], $data, function ($message) use ($data) {
                    $message->subject($data['subject_penyelia_vc']);
                    $message->to($data['to_penyelia_vc']);
                    $message->from('eTempah@miti.gov.my', "eTempah");
                });
            }
        }

        if(!empty($application->applicationVc)) {
            if ($request->button == '12' || $application->applicationRoom->status_room_id == '12') {
                    Mail::send(['html' => 'emails.penyelia_vc_batal'], $data, function ($message) use ($data) {
                    $message->subject($data['subject_pemohon']);
                    $message->to($data['to_penyelia_vc']);
                    $message->from('eTempah@miti.gov.my', "eTempah");
                });
            }
        }

        Mail::send(['html' => 'emails.pemohon'], $data, function ($message) use ($data) {
            $message->subject($data['subject_pemohon']);
            $message->to($data['to_pemohon']);
            $message->from('eTempah@miti.gov.my', "eTempah");
        });

        return redirect('/admin/application_room/show/' . encrypt($application->id))->with('successMessage', $msg);
            // return $application;
    }

    public function resultEdit($applicationId)
    {
        $rooms = ApplicationRoom::where('application_id', $applicationId)->get();

        if ($rooms->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tiada bilik ditemui.']);
        }

        foreach ($rooms as $room) {
            $room->update([
                'status_room_id' => 13,
                'cancelled_by_admin' => true,
                'cancel_reason' => 'Pindaan semasa kelulusan'
            ]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApplicationRoom  $applicationRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationRoom $applicationRoom)
    {
        //
    }
}

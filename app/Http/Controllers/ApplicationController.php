<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationRoom;
use App\Models\ApplicationVc;
use App\Models\Department;
use App\Http\Requests\ApplicationRequest;
use App\Models\Position;
use App\Models\Room;
use App\Models\User;
use App\Models\Batch;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use DateTime;

class ApplicationController extends Controller
{

    public function index($tag)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

        $status_for_approve = ['1', '3'];

        if ($tag == '1') { //rekod

            $applications = Application::where('user_id', $user_id)
                ->whereDate('tarikh_hingga', '>=', Carbon::today())
                ->get()
                ->groupBy('batch_id');

        } elseif ($tag == '2') { //Sejarah

            $applications = Application::where('user_id', $user_id)
                ->whereDate('tarikh_hingga', '<', Carbon::today())
                ->get()
                ->groupBy('batch_id');
        }

        session()->put('tag', $tag);

        return view('applications.index', compact('applications', 'tag'));
    }

    public function create()
    {
        $departments = Department::where('status','aktif')->orderBy('nama', 'ASC')->get();
        $positions = Position::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        $user = User::find(Auth::id());

        $department = $user->profile->department_id;

        $rooms = Room::whereHas('departments', function ($q) use ($department) {
            $q->where('department_id', $department);
        })->orWhereIn('is_auto', ['N', 'S'])->get();

        return view('applications.create', compact('departments', 'rooms', 'positions', 'user'));
    }

   public function checkAvailability(Request $request)
    {
        $start = Carbon::createFromFormat('d/m/Y H:i', $request->start);
        $end   = Carbon::createFromFormat('d/m/Y H:i', $request->end);

        $conflicts = \App\Models\Application::where('room_id', $request->room_id)
            ->join('application_rooms', 'applications.id', '=', 'application_rooms.application_id')
            ->whereIn('application_rooms.status_room_id', [2, 3, 6, 14])
            ->get(['tarikh_mula', 'tarikh_hingga']);

        $isClash = false;

        foreach ($conflicts as $conflict) {
            $conflictStart = Carbon::parse($conflict->tarikh_mula);
            $conflictEnd   = Carbon::parse($conflict->tarikh_hingga);

            // Rule overlap: clash kalau tempahan bertindih walaupun separuh
            if ($start < $conflictEnd && $end > $conflictStart) {
                $isClash = true;
                break;
            }
        }

        return response()->json(['available' => !$isClash]);
    }

    public function store(ApplicationRequest $request)
    {
        // dd($request->all(), $request->allFiles());
        $roomId = $request->input('room');
        $isAuto = $request->input('is_auto');
        $isUpload = $request->input('is_upload');
        $isPantry = $request->input('is_pantry');

        $room = Room::find($roomId);

        $room_users = $room->users;

        $supervisorsRooms_email = $room_users->pluck('email')->toArray();

        // 1. Try to insert data
        try {
        $results = DB::transaction(function () use ($request, $roomId) {

            $application = null;
            $tarikh_list = [];

            $batch = Batch::create();
            $surat_emel_path = null;

            if ($request->hasFile('surat_emel')) {
                $file = $request->file('surat_emel');
                if (is_array($file)) {
                    $file = $file[0]; // kalau multiple upload, ambil satu je
                }

                $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('lampiran'), $filename);
                $surat_emel_path = '/lampiran/' . $filename;
            }

            foreach ($request->bookings as $booking) {

                $mula = Carbon::parse($booking['start'])->format('Y-m-d H:i:s');
                $tamat = Carbon::parse($booking['end'])->format('Y-m-d H:i:s');

                $application = Application::create([
                    'batch_id' => $batch->id,
                    'room_id' => $roomId,
                    'tarikh_mula' => $mula,
                    'tarikh_hingga' => $tamat,
                    'user_id' => auth()->id(),
                    'nama_mesyuarat' => $request->nama_mesyuarat,
                    'kategori_pengerusi' => $request->kategori_pengerusi,
                    'nama_pengerusi' => $request->nama_pengerusi,
                    'bilangan_tempahan' => $request->bilangan_tempahan,
                    'perakuan' => $request->perakuan,
                    'created_at' => now(),
                    'created_by' => Auth::id(),
                ]);

                if($request->is_auto == 'Y'){

                    ApplicationRoom::create([
                        'application_id' => $application->id,
                        'status_room_id' => 1,
                        'nama_urusetia' => $request->nama_urusetia,
                        'position_id' => $request->jawatan_urusetia,
                        'department_id' => $request->bahagian_urusetia,
                        'emel_urusetia' => $request->email_urusetia,
                        'no_extension_urusetia' => $request->no_sambungan_urusetia,
                        'no_telefon_bimbit_urusetia' => $request->no_bimbit_urusetia,
                        'penganjur' => $request->penganjur,
                        'nama_penganjur' => $request->nama_penganjur,
                        'kategori_mesyuarat' => $request->kategori_mesyuarat,
                        'surat' => $surat_emel_path,
                        'ahli' => $request->ahli,
                        'sajian' => $request->sajian,
                        'minum_pagi' => $request->minum_pagi,
                        'makan_tengahari' => $request->makan_tengahari,
                        'minum_petang' => $request->minum_petang,
                        'catatan' => $request->catatan_room,
                        'created_by' => Auth::id(),
                    ]);
                }

                if ($request->vc_selected == '1' || $request->vc_selected == 'on' || $request->is_auto == 'N') {

                    if($request->is_auto == 'N'){
                        $status_vc_id = '2';
                    }else{
                        $status_vc_id = '1';
                    }

                    ApplicationVc::create([
                        'application_id'   => $application->id,
                        'status_vc_id'     => $status_vc_id,
                        'webex'            => $request->akaun_webex,
                        'nama_aplikasi'    => $request->nama_aplikasi,
                        'peralatan'        => $request->peralatan,
                        'catatan'          => $request->catatan_vc,
                        'created_at'       => now(),
                        'created_by'       => Auth::id(),
                    ]);
                }
            }

            $application->load(['applicationRoom', 'applicationVc']);

            return [
                'application' => $application,
                'tarikh_list' => $tarikh_list,
            ];

            $application_id = $application->id;

            // $msg = 'Permohonan tempahan anda telah dihantar untuk diproses.';

            // return redirect('/application/show/' . encrypt($application_id))->with('successMessage', $msg);

        }); // ✅ closes DB::transaction

        // 2. Try sending email
        // Set data

        $application = $results['application'];
        $tarikh_list = $results['tarikh_list'];

        $tempahan = match (true) {
            !empty($application->applicationRoom) && !empty($application->applicationVc) => 'bilik dan VC',
            !empty($application->applicationRoom) => 'bilik',
            !empty($application->applicationVc) => 'VC',
            default => 'undefined 01: Ralat Permohonan',
        };

         //collect data
            $applications=  Application::where('batch_id', $application->batch_id)->get();
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

        $action_pemohon = 'dihantar untuk diproses';
        $action_penyelia = 'untuk tindakan';

        $status_bilik = '';
        $status_bilik_id = '';
        $catatan_room = '';
        $catatan_room_penyelia = '';
        $vc_komen_ditolak = '';

       $nama_pengerusi = $application->nama_pengerusi ?? $application->kategori_pengerusi;

        if (!empty($application->applicationRoom)) {
            $status_bilik = $application->applicationRoom->statusRoom->status_pemohon ?? '-';
            $status_bilik_id = $application->applicationRoom->status_room_id ?? '';
            $catatan_room = $application->applicationRoom->catatan ?? '-';
            $catatan_room_penyelia = $application->applicationRoom->catatan_penyelia ?? '-';
        }

        if (!empty($application->applicationVc)) {
            $vc_komen_ditolak = $application->applicationVc->komen_ditolak ?? '-';
        }

        $apply_vc = 0;
        $status_vc_id = '';
        $status_vc = '';
        $webex = '';
        $peralatan = '';
        $nama_aplikasi = '';
        $link_webex = '';
        $id_webex = '';
        $password_webex = '';
        $password_expired = '';
        $catatan_vc = '';
        $catatan_penyelia_vc = '';
        $email_penyeliaVc = '';

        if (!empty($application->applicationVc)) {
            $apply_vc = 1;
            $applicationVc = $application->applicationVc;

            $status_vc_id = $applicationVc->status_vc_id ?? '';
            $status_vc = $applicationVc->statusVc->status_pemohon ?? '';

            $catatan_vc = $applicationVc->catatan ?? '';
            $catatan_penyelia_vc = $applicationVc->catatan_penyelia ?? '';

            $webex = $applicationVc->webex ?? 0;
            $peralatan = $applicationVc->peralatan ?? 0;

            if ($peralatan == 1) {
                $peralatan = 'YA';
            } else {
                $peralatan = 'TIDAK';
            }

            if ($webex == 1) {
                $webex = 'YA';
                $nama_aplikasi = '';
                $link_webex = $applicationVc->link_webex ?? '';
                $id_webex = $applicationVc->id_webex ?? '';
                $password_webex = $applicationVc->password_webex ?? '';
                $password_expired = !empty($applicationVc->password_expired)
                    ? date('d-m-Y g:i A', strtotime($applicationVc->password_expired))
                    : '';
            } else {
                $webex = 'TIDAK';
                $nama_aplikasi = $applicationVc->nama_aplikasi ?? '';
            }

            $vc_komen_ditolak = $application->applicationVc->komen_ditolak ?? null;

            $email_penyeliaVc = User::role('approver-vc')->pluck('email')->toArray();


        }

         if (!empty($application)) {
                $data = array(
                    'to_pemohon' => Auth::user()->email,
                    'to_penyelia_vc' => $email_penyeliaVc,
                    'tempahan' => $tempahan,
                    'to_penyelia' => $supervisorsRooms_email,
                    // 'subject_pemohon' => 'Makluman: Permohonan Baru Tempahan ' . $tempahan . ' di ' . $application->room->nama . ' pada ' . $tarikh_mula . ' Sehingga ' . $tarikh_hingga,
                    // 'subject_penyelia' => 'Tindakan: Permohonan Baru Tempahan ' . $tempahan . ' di ' . $application->room->nama . ' pada ' . $tarikh_mula . ' Sehingga ' . $tarikh_hingga,
                    // 'subject_penyelia_vc' => 'Tindakan: Permohonan Baru Tempahan ' . $tempahan . ' di ' . $application->room->nama . ' pada ' . $tarikh_mula . ' Sehingga ' . $tarikh_hingga,
                    'subject_pemohon' => 'Makluman: Permohonan Baru Tempahan ',
                    'subject_penyelia' => 'Tindakan: Permohonan Baru Tempahan Bilik',
                    'subject_penyelia_vc' => 'Tindakan: Permohonan Baru Tempahan VC',
                    'action_pemohon' => $action_pemohon,
                    'action_penyelia' => $action_penyelia,
                    'action_penyelia2' => '',
                    'action_penyelia_vc' => 'untuk tindakan',
                    'id' => $application->id,
                    'batch_id' => $application->batch_id,
                    'nama_pemohon' => Auth::user()->name,
                    'bahagian_pemohon' => Auth::user()->profile->department->nama,
                    'nama_mesyuarat' => $application->nama_mesyuarat,
                    'bilik' => $application->room->nama,
                    'status_bilik' => $status_bilik,
                    'status_bilik_id' => $status_bilik_id,
                    'tarikh_list' => $tarikh_list,
                    'tarikh_mula' => '',
                    'tarikh_hingga' => '',
                    'nama_pengerusi' => $nama_pengerusi,
                    'bilangan_tempahan' => $application->bilangan_tempahan,
                    'catatan_room' => $catatan_room,
                    'catatan_room_penyelia' => $catatan_room_penyelia,
                    'apply_vc' => $apply_vc,
                    'status_vc_id' => $status_vc_id,
                    'status_vc' => $status_vc,
                    'link_webex' => $link_webex,
                    'id_webex' => $id_webex,
                    'senarai_tarikh' => $senarai_tarikh,
                    'password_webex' => $password_webex,
                    'password_expired' => $password_expired,
                    'catatan_penyelia_vc' => $catatan_penyelia_vc,
                    'webex' => $webex,
                    'peralatan' => $peralatan,
                    'nama_aplikasi' => $nama_aplikasi,
                    'catatan_vc' => $catatan_vc,
                    'vc_komen_ditolak' => $vc_komen_ditolak,
                    'note' => '',
                );
            }

        //   return $data['to_pemohon'];
        try {
            Mail::send(['html' => 'emails.pemohon'], $data, function ($message) use ($data) {
                $message->subject($data['subject_pemohon']);
                $message->to($data['to_pemohon']);
                $message->from('eTempah@miti.gov.my', "eTempah");
            });
        } catch (\Exception $e) {
            \Log::error("Email to pemohon failed: " . $e->getMessage());
            session()->flash('email_error', 'Notifikasi e-mel tidak dapat dihantar.  Sila maklumkan Pentadbir Sistem.');
        }

        if ($room->email_status == 'Y') {
            try {
                Mail::send(['html' => 'emails.penyelia'], $data, function ($message) use ($data) {
                    $message->subject($data['subject_penyelia']);
                    $message->to($data['to_penyelia']);
                    $message->from('eTempah@miti.gov.my', "eTempah");
                });
            } catch (\Exception $e) {
                \Log::error("Email to penyelia failed: " . $e->getMessage());
                session()->flash('email_error', 'Failed to send email to penyelia.');
            }
        }

        if ($status_vc_id == '2') {
            try {
                Mail::send(['html' => 'emails.penyelia_vc'], $data, function ($message) use ($data) {
                    $message->subject($data['subject_penyelia_vc']);
                    $message->to($data['to_penyelia_vc']);
                    $message->from('eTempah@miti.gov.my', "eTempah");
                });
            } catch (\Exception $e) {
                \Log::error("Email to penyelia VC failed: " . $e->getMessage());
                session()->flash('email_error', 'Failed to send email to penyelia VC.');
            }
        }
        // continue with redirect : If email problem to send, user can proceed the application.
        return redirect('/application/show/' . encrypt($application->id))
            ->with('successMessage', 'Permohonan berjaya dihantar.');

        // 3. Return success + email info
        // return redirect('/application/show/' . encrypt($application->id))
        //     ->with('successMessage', 'Permohonan berjaya dihantar' . $errorMessage);

            return redirect('/application/show/' . encrypt($application->id))
        ->with('successMessage', 'Permohonan berjaya dihantar.  Pemohon akan menerima notifikasi e-mel.');

        } catch (\Exception $e) {
            \Log::error('Store failed: ' . $e->getMessage());
            return back()->with('error', 'Ralat semasa menyimpan data.');
        }
    }

    public function createvc($batch_id)
    {
        $applications = Application::where('batch_id', $batch_id)->get();
        $application = Application::where('batch_id', $batch_id)->first();
        $departments = Department::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        $positions = Position::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        $user = User::find(Auth::id());

        $department = $user->profile->department_id;

        $rooms = Room::whereHas('departments', function ($q) use ($department) {
            $q->where('department_id', $department);
        })->orWhere('is_auto', 'N')->get();

        return view('applications.create_vc', compact('applications','application', 'departments', 'rooms', 'positions', 'user'));
    }

    public function storevc(Request $request, $batch_id)
    {
        $request->validate(
            [
                'vc_selected' => 'required',
                'akaun_webex' => 'required',
                'peralatan' => 'required',
                'nama_aplikasi' => 'required_if:akaun_webex,=,0',
                'perakuan' => 'required',
            ],
            [
                'vc_selected.required' => 'Permohonan Tempahan VC wajib dipilih',
                'akaun_webex.required' => 'Akaun WEBEX wajib di pilih',
                'peralatan.required' => 'Peralatan VC wajib di pilih',
                'nama_aplikasi.required_if' => 'Nama Aplikasi wajib di isi',
                'perakuan.required' => 'Perakuan diperlukan',
            ]
        );

        $applications = Application::where('batch_id', $batch_id)->get();
        $application = $applications->first();
        $user = User::where('id', Auth::id())->first();

        if (!$application) {
            return redirect()->back()->with('errorMessage', 'Tiada permohonan dalam batch ini');
        }

        // ambil room dan email supervisor
        $roomId = $application->room_id;
        $room_users = Room::find($roomId)?->users ?? collect();
        $supervisorsRooms_email = $room_users->pluck('email')->toArray();

        // check jika sudah ada ApplicationVc untuk application pertama
        $applicationVcExists = ApplicationVc::where('application_id', $application->id)->exists();

        if ($applicationVcExists) {
            return redirect()->back()->with('errorMessage', 'Permohonan VC telah wujud');
        } else {
            foreach ($applications as $app) {
                // check lagi setiap application
                $exists = ApplicationVc::where('application_id', $app->id)->exists();
                if ($exists) {
                    continue; // skip kalau dah ada
                }

                $applicationVc = new ApplicationVc();
                $applicationVc->application_id = $app->id;

                if ($app->applicationRoom && $app->applicationRoom->status_room_id == '1') {
                    $status_vc = '1';
                } elseif ($app->applicationRoom && in_array($app->applicationRoom->status_room_id, ['2', '14'])) {
                    $status_vc = '2';
                } else {
                    $status_vc = null;
                }

                $applicationVc->status_vc_id = $status_vc;
                $applicationVc->webex = $request->akaun_webex;
                $applicationVc->nama_aplikasi = $request->nama_aplikasi;
                $applicationVc->peralatan = $request->peralatan;
                $applicationVc->catatan = $request->catatan_vc;
                $applicationVc->created_at = now();
                $applicationVc->created_by = Auth::id();
                $applicationVc->save();
            }
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

        $action_pemohon = 'dihantar untuk diproses';
        $action_penyelia = 'untuk tindakan';

        // $webex = '';
        $nama_aplikasi = '';
        $link_webex = '';
        $id_webex = '';
        $password_webex = '';
        $password_expired = '';
        $vc_komen_ditolak = null;

        $status_vc_id = $applicationVc->status_vc_id;
        $catatan_vc = $applicationVc->catatan;
        $catatan_penyelia_vc = $applicationVc->catatan_penyelia;
        $webex = $applicationVc->webex;
        $peralatan = $applicationVc->peralatan;
        $status_bilik_id = $application->applicationRoom->status_room_id;

        if ($peralatan == 1) {
            $peralatan = 'YA';
        } else {
            $peralatan = 'TIDAK';
        }

        if ($webex == 1) {
            $webex = 'YA';
            $nama_aplikasi = '';
            $link_webex = $applicationVc->link_webex;
            $id_webex = $applicationVc->id_webex;
            $password_webex = $applicationVc->password_webex;
            $password_expired = date('d-m-Y g:i A', strtotime($applicationVc->password_expired));
        } else {
            $webex = 'TIDAK';
            $nama_aplikasi = $applicationVc->nama_aplikasi;
        }

        $penyeliaVc_email = User::role('approver-vc')->pluck('email')->toArray();

        $data = array(
            'to_pemohon' => $user->email,
            'tempahan' => 'VC',
            'to_penyelia' => $supervisorsRooms_email,
            'to_penyeliaVc' => $penyeliaVc_email,
            'subject_pemohon' => 'Makluman: Permohonan Baru Tempahan VC di ' . $application->room->nama,
            'subject_penyelia' => 'Tindakan: Permohonan Baru Tempahan VC di ' . $application->room->nama,
            'action_pemohon' => $action_pemohon,
            'action_penyelia_vc' => 'untuk tindakan',
            'action_penyelia2' => '',
            'id' => $application->id,
            'batch_id' => $application->id,
            'nama_pemohon' => $user->name,
            'bahagian_pemohon' => $user->profile->department->nama,
            'nama_mesyuarat' => $application->nama_mesyuarat,
            'bilik' => $application->room->nama,
            'status_bilik' => $application->applicationRoom->statusRoom->status_pemohon,
            'status_bilik_id' => $status_bilik_id,
            'senarai_tarikh' => $senarai_tarikh,
            'nama_pengerusi' => $application->nama_pengerusi,
            'bilangan_tempahan' => $application->bilangan_tempahan,
            'catatan_room' => $application->applicationRoom->catatan,
            'catatan_room_penyelia' => $application->applicationRoom->catatan_penyelia,
            'apply_vc' => '1',
            'status_vc_id' => $status_vc,
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
            'vc_komen_ditolak' => $vc_komen_ditolak,
        );

        Mail::send(['html' => 'emails.pemohon'], $data, function ($message) use ($data) {
            $message->subject($data['subject_pemohon']);
            $message->to($data['to_pemohon']);
            $message->from('eTempah@miti.gov.my', "eTempah");
        });

        // $email_penyeliaVc = User::role('approver-vc')->pluck('email')->toArray();

        if ($application->applicationRoom->status_room_id == '2' || $application->applicationRoom->status_room_id == '14') {

            Mail::send(['html' => 'emails.penyelia_vc'], $data, function ($message) use ($data) {
                $message->subject($data['subject_penyelia']);
                $message->to($data['to_penyeliaVc']);
                $message->from('eTempah@miti.gov.my', "eTempah");
            });
        }

        $departments = Department::get();
        $rooms = Room::get();
        $positions = Position::get();

        $successMessage = 'Permohonan tempahan VC anda telah dihantar untuk diproses.';

        return view('applications.view', compact('applications','application', 'departments', 'rooms', 'positions', 'user', 'successMessage'));
    }

    public function show($applicationId)
    {
        $applicationId = decrypt($applicationId);
        $act = request()->act;
        session()->put('act', $act);

        $departments = Department::orderBy('nama', 'ASC')->get();
        $positions = Position::orderBy('nama', 'ASC')->get();
        $rooms = Room::orderBy('nama', 'ASC')->get();

        $user = User::where('id', Auth::id())->first();

        $application = Application::where('id', $applicationId)->first();

        if ($application->batch_id && $application->batch_id != 0) {
            // Batch exists: show all applications in same batch
            $applications = Application::where('batch_id', $application->batch_id)
                ->orderBy('tarikh_mula')
                ->get();
        } else {
            // No batch: only show this single application
            $applications = collect([$application]);
        }

        $link = url()->current();
        $contains = Str::contains($link, 'admin');

        if ($act == 'cancel_room_vc' || $act == 'cancel_vc' || $act == 'cancel_room') {
            return view('applications.view_cancel', compact('application', 'applications','departments', 'rooms', 'positions', 'user', 'contains'));
        } else {
            return view('applications.view', compact('application', 'applications', 'departments', 'rooms', 'positions', 'user', 'contains'));
        }
    }

    public function edit(Request $request, Application $application)
    {
        $departments = Department::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        $positions = Position::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        $user = User::find(Auth::id());

        $department = $user->profile->department_id;
        $rooms = Room::whereHas('departments', function ($q) use ($department) {
            $q->where('department_id', $department);
        })->orWhere('is_auto', 'N')->get();

        return view('applications.edit', compact('application', 'departments', 'rooms', 'positions', 'user'));
    }

    public function update(ApplicationRequest $request, Application $application)
    {
        $id = Auth::id();
        $user =  User::find($id);

        // $room_selected = $request->room_selected;
        $vc_selected = $request->vc_selected;

        $roomId = substr_replace($request->room, "", -3);

        $bilangan_tempahan_edit = $request->bilangan_tempahan;

        $application->room_id = $roomId;
        $application->nama_mesyuarat = $request->nama_mesyuarat;
        $application->tarikh_mula = $request->tarikh_mula;
        $application->tarikh_hingga = $request->tarikh_hingga;
        $application->kategori_pengerusi = $request->kategori_pengerusi;

        // Untuk padam nama pengerusi sekiranya pemohon edit kepada pengerusi bukan Lain-lain
        if ($request->kategori_pengerusi <> '0') {
            $application->nama_pengerusi = $request->kategori_pengerusi;
        } else {
            $application->nama_pengerusi = $request->nama_pengerusi;
        }

        $application->bilangan_tempahan = $bilangan_tempahan_edit;
        $application->perakuan = $request->perakuan;
        $application->created_at = now();
        $application->created_by = $id;
        $application->save();

        if ($request->is_auto_input == 'Y') {

            if (empty($application->applicationRoom)) {
                $applicationRoom = new ApplicationRoom();
                $applicationRoom->application_id = $application->id;
                $applicationRoom->status_room_id = '1'; //Baru/Dalam Proses
                $applicationRoom->nama_urusetia = $request->nama_urusetia;
                $applicationRoom->position_id = $request->jawatan_urusetia;
                $applicationRoom->department_id = $request->bahagian_urusetia;
                $applicationRoom->emel_urusetia = $request->email_urusetia;
                $applicationRoom->no_extension_urusetia = $request->no_sambungan_urusetia;
                $applicationRoom->no_telefon_bimbit_urusetia = $request->no_bimbit_urusetia;
                $applicationRoom->penganjur = $request->penganjur;
                $applicationRoom->nama_penganjur = $request->nama_penganjur;
                $applicationRoom->kategori_mesyuarat = $request->kategori_mesyuarat;

                if ($request->hasFile('surat_emel')) {
                    if ($files = $request->file('surat_emel')) {
                        $destinationPath = "lampiran/";
                        $surat_emel = Str::random(32) . '.' . $files->getClientOriginalExtension();
                        $request->file('surat_emel')->move($destinationPath, $surat_emel);
                    }
                    $applicationRoom->surat = '/' . $destinationPath . $surat_emel;
                }

                $applicationRoom->ahli = $request->ahli;
                $applicationRoom->sajian = $request->sajian;
                $applicationRoom->minum_pagi = $request->minum_pagi;
                $applicationRoom->makan_tengahari = $request->makan_tengahari;
                $applicationRoom->minum_petang = $request->minum_petang;
                $applicationRoom->catatan = $request->catatan_room;
                $applicationRoom->created_at = now();
                $applicationRoom->created_by = $id;
                $applicationRoom->save();

                $applicationRoom->application->applicationVc->status_vc_id = '1';
                $applicationRoom->application->applicationVc->save();

                $data = array(
                    'to' => $user->email,
                    'subject' => 'Permohonan Tempahan Bilik/VC Untuk Kelulusan',
                    'id' => $application->id,
                    'nama_mesyuarat' => $application->nama_mesyuarat,
                    'bilik' => $application->room->nama,
                    'tarikh_mula' => $application->tarikh_mula,
                    'tarikh_hingga' => $application->tarikh_hingga,
                    'nama_pengerusi' => $application->nama_pengerusi,
                    'bilangan_tempahan' => $application->bilangan_tempahan,
                );
                Mail::send(['html' => 'emails.permohonan_baru'], $data, function ($message) use ($data) {
                    $message->subject($data['subject']);
                    $message->to($data['to']);
                    $message->from('eTempah@miti.gov.my', "eTempah");
                });
            } else {

                $application->applicationRoom->status_room_id = '1'; //Baru/Dalam Proses
                $application->applicationRoom->nama_urusetia = $request->nama_urusetia;
                $application->applicationRoom->position_id = $request->jawatan_urusetia;
                $application->applicationRoom->department_id = $request->bahagian_urusetia;
                $application->applicationRoom->emel_urusetia = $request->email_urusetia;
                $application->applicationRoom->no_extension_urusetia = $request->no_sambungan_urusetia;
                $application->applicationRoom->no_telefon_bimbit_urusetia = $request->no_bimbit_urusetia;
                $application->applicationRoom->penganjur = $request->penganjur;

                // Untuk padam nama penganjur sekiranya jenis penganjur edit kepada Sendiri
                if ($request->penganjur == 'SENDIRI') {
                    $application->applicationRoom->nama_penganjur = '';
                } else {
                    $application->applicationRoom->nama_penganjur = $request->nama_penganjur;
                }
                $application->applicationRoom->kategori_mesyuarat = $request->kategori_mesyuarat;

                if ($request->hasFile('surat_emel')) {
                    if ($files = $request->file('surat_emel')) {
                        $destinationPath = "lampiran/";
                        $surat_emel = Str::random(32) . '.' . $files->getClientOriginalExtension();
                        $request->file('surat_emel')->move($destinationPath, $surat_emel);
                    }
                    $application->applicationRoom->surat = '/' . $destinationPath . $surat_emel;
                }

                $application->applicationRoom->ahli = $request->ahli;
                $application->applicationRoom->sajian = $request->sajian;

                if ($request->minum_pagi == 'on') {
                    $minum_pagi = '1';
                } else {
                    $minum_pagi = '';
                }

                if ($request->makan_tengahari == 'on') {
                    $makan_tengahari = '1';
                } else {
                    $makan_tengahari = '';
                }

                if ($request->minum_petang == 'on') {
                    $minum_petang = '1';
                } else {
                    $minum_petang = '';
                }

                // Untuk padam maklumat yang tiada kaitan dengan pilihan sajian
                if ($request->sajian == 'Tidak Perlu') {
                    $application->applicationRoom->minum_pagi = '';
                    $application->applicationRoom->makan_tengahari = '';
                    $application->applicationRoom->minum_petang = '';
                } elseif ($request->sajian == 'Pantri Dalaman') {
                    $application->applicationRoom->minum_pagi = $minum_pagi;
                    $application->applicationRoom->makan_tengahari = '';
                    $application->applicationRoom->minum_petang = $minum_petang;
                } elseif ($request->sajian == 'Katerer Luar') {
                    $application->applicationRoom->minum_pagi = $minum_pagi;
                    $application->applicationRoom->makan_tengahari = $makan_tengahari;
                    $application->applicationRoom->minum_petang = $minum_petang;
                }

                $application->applicationRoom->catatan = $request->catatan_room;
                $application->applicationRoom->created_at = now();
                $application->applicationRoom->created_by = $id;
                $application->applicationRoom->save();

                $data = array(
                    'to' => $user->email,
                    'subject' => 'Permohonan Tempahan Bilik/VC Untuk Kelulusan (Kemaskini)',
                    'action' => 'Permohonan Baru (kemaskini)',
                    'id' => $application->id,
                    'nama_mesyuarat' => $application->nama_mesyuarat,
                    'bilik' => $application->room->nama,
                    'tarikh_mula' => $application->tarikh_mula,
                    'tarikh_hingga' => $application->tarikh_hingga,
                    'nama_pengerusi' => $application->nama_pengerusi,
                    'bilangan_tempahan' => $application->bilangan_tempahan,
                );
                Mail::send(['html' => 'emails.permohonan_baru'], $data, function ($message) use ($data) {
                    $message->subject($data['subject']);
                    $message->to($data['to']);
                    $message->from('eTempah@miti.gov.my', "eTempah");
                });
            }
        } elseif ($request->is_auto_input == 'N') {

            $application->applicationRoom->status_room_id = '7';
            $application->applicationRoom->save();
            $data = array(
                'to' => $user->email,
                'subject' => 'Permohonan Tempahan Bilik/VC Untuk Kelulusan (Kemaskini)',
                'action' => 'Permohonan Baru (Batal Oleh Pemohon)',
                'id' => $application->id,
                'nama_mesyuarat' => $application->nama_mesyuarat,
                'bilik' => $application->room->nama,
                'tarikh_mula' => $application->tarikh_mula,
                'tarikh_hingga' => $application->tarikh_hingga,
                'nama_pengerusi' => $application->nama_pengerusi,
                'bilangan_tempahan' => $application->bilangan_tempahan,
            );
            Mail::send(['html' => 'emails.permohonan_baru'], $data, function ($message) use ($data) {
                $message->subject($data['subject']);
                $message->to($data['to']);
                $message->from('eTempah@miti.gov.my', "eTempah");
            });
        }

        if ($vc_selected == 'on') {
            $applicationVc = new ApplicationVc();
        } else {
            $applicationVc = ApplicationVc::where('application_id', $application->id)->first();
            if (!empty($applicationVc)) {
                $applicationVc->application_id = $application->id;

                if ($application->applicationRoom->status_room_id == '7') {
                    // return $application->applicationRoom->status_room_id;
                    $applicationVc->status_vc_id = '2';
                    //send email dalam proses
                } else {
                    $applicationVc->status_vc_id = '1';
                }

                $applicationVc->webex = $request->webex;
                $applicationVc->peralatan = $request->peralatan;

                if ($request->webex == '1') {
                    $applicationVc->nama_aplikasi = '';
                } elseif ($request->webex == '0') {
                    $applicationVc->nama_aplikasi = $request->nama_aplikasi;
                }

                $applicationVc->peralatan = $request->peralatan;
                $applicationVc->catatan = $request->catatan_vc;
                $applicationVc->created_at = now();
                $applicationVc->created_by = $id;
                $applicationVc->save();

                $data = array(
                    'to' => $user->email,
                    'subject' => 'Permohonan Tempahan Bilik/VC Untuk Kelulusan',
                    'action' => 'Permohonan Baru',
                    // 'content' => 'Test Email permohonan baru',
                    'id' => $application->id,
                    'nama_mesyuarat' => $application->nama_mesyuarat,
                    'bilik' => $application->room->nama,
                    'tarikh_mula' => $application->tarikh_mula,
                    'tarikh_hingga' => $application->tarikh_hingga,
                    'nama_pengerusi' => $application->nama_pengerusi,
                    'bilangan_tempahan' => $application->bilangan_tempahan,
                );
                Mail::send(['html' => 'emails.permohonan_baru'], $data, function ($message) use ($data) {
                    $message->subject($data['subject']);
                    $message->to($data['to']);
                    $message->from('eTempah@miti.gov.my', "eTempah");
                });
            }
        }

        $msg = 'Permohonan telah berjaya dikemaskini.';

        return redirect('/application/show/' . encrypt($application->id))->with('successMessage', $msg);
    }

    public function destroy(Application $application)
    {
    }

    public function recreate($batch)
    {

        $batch = decrypt($batch);

        $application = Application::where('batch_id',$batch)->first();
        $applications = Application::where('batch_id',$batch)->get();
        // dd($applications);
        $departments = Department::where('status', 'aktif')->orderBy('nama', 'ASC')->get();
        $positions = Position::where('status', 'aktif')->orderBy('nama', 'ASC')->get();

        $user = User::find(Auth::id());

        $department = $user->profile->department_id;

        $rooms = Room::whereHas('departments', function ($q) use ($department) {
            $q->where('department_id', $department);
        })->orWhereIn('is_auto', ['N', 'S'])->get();

        $link = url()->current();
        // $contains = Str::contains($link, 'recreate');ori
        $contains = Str::contains($link, 'admin');
        $recreate = Str::contains($link, 'recreate');

        return view('applications.recreate', compact('applications','application', 'departments', 'rooms', 'positions', 'user', 'contains'));
    }

    // public function restore(ApplicationRequest $request)
    // {
    //     $id = Auth::id();
    //     $user =  User::find($id);

    //     $dateString = $request->input('tarikh_mula'); // "23/04/2025"
    //     $tarikh_mula = Carbon::createFromFormat('d/m/Y', $dateString)->startOfDay();

    //     $dateStringTo = $request->input('tarikh_hingga'); // "23/04/2025"
    //     $tarikh_hingga = Carbon::createFromFormat('d/m/Y', $dateStringTo)->startOfDay();

    //     // $tarikh_mula = $request->input('tarikh_mula');
    //     // $tarikh_mula_deformat = Carbon::createFromFormat('d/m/y', $tarikh_mula);

    //     // $tarikh_hingga = $request->input('tarikh_hingga');
    //     // $tarikh_hingga_deformat = Carbon::createFromFormat('d/m/y', $tarikh_hingga);

    //     $roomId = substr_replace($request->room, "", -3);

    //     $application = new Application();
    //     $application->user_id = $id;
    //     $application->room_id = $roomId;
    //     $application->nama_mesyuarat = $request->nama_mesyuarat;
    //     $application->tarikh_mula = $tarikh_mula;
    //     $application->tarikh_hingga = $tarikh_hingga;
    //     $application->kategori_pengerusi = $request->kategori_pengerusi;

    //     if ($application->kategori_pengerusi == '0') {
    //         $application->nama_pengerusi = $request->nama_pengerusi;
    //     } else {
    //         $application->nama_pengerusi = $request->kategori_pengerusi;
    //     }

    //     $application->bilangan_tempahan = $request->bilangan_tempahan;
    //     $application->perakuan = $request->perakuan;
    //     $application->created_at = now();
    //     $application->created_by = Auth::id();
    //     $application->save();

    //     //Tambah elak duplicate Room (19/9/2024)
    //     $idRoomExists = ApplicationRoom::where('application_id', $application->id)->exists();

    //     if ($idRoomExists) {
    //         return redirect()->back()->with('errorMessage', 'Permohonan Bilik telah wujud');
    //     }else{

    //         if ($request->is_auto_input == 'Y') {

    //             $applicationRoom = new ApplicationRoom();
    //             $applicationRoom->application_id = $application->id;
    //             $applicationRoom->status_room_id = '1'; //Baru/Dalam Proses
    //             $applicationRoom->nama_urusetia = $request->nama_urusetia;
    //             $applicationRoom->position_id = $request->jawatan_urusetia;
    //             $applicationRoom->department_id = $request->bahagian_urusetia;
    //             $applicationRoom->emel_urusetia = $request->email_urusetia;
    //             $applicationRoom->no_extension_urusetia = $request->no_sambungan_urusetia;
    //             $applicationRoom->no_telefon_bimbit_urusetia = $request->no_bimbit_urusetia;
    //             $applicationRoom->penganjur = $request->penganjur;
    //             $applicationRoom->nama_penganjur = $request->nama_penganjur;
    //             $applicationRoom->kategori_mesyuarat = $request->kategori_mesyuarat;

    //             if ($request->hasFile('surat_emel')) {
    //                 if ($files = $request->file('surat_emel')) {
    //                     $destinationPath = "lampiran/";
    //                     $surat_emel = Str::random(32) . '.' . $files->getClientOriginalExtension();
    //                     $request->file('surat_emel')->move($destinationPath, $surat_emel);
    //                 }
    //                 $applicationRoom->surat = '/' . $destinationPath . $surat_emel;
    //             }

    //             $applicationRoom->ahli = $request->ahli;
    //             $applicationRoom->sajian = $request->sajian;
    //             $applicationRoom->minum_pagi = $request->minum_pagi;
    //             $applicationRoom->makan_tengahari = $request->makan_tengahari;
    //             $applicationRoom->minum_petang = $request->minum_petang;
    //             $applicationRoom->catatan = $request->catatan_room;
    //             $applicationRoom->created_at = now();
    //             $applicationRoom->created_by = $id;
    //             $applicationRoom->save();
    //         }
    //     }


    //     if ($request->vc_selected == '1') {

    //         //Tambah elak duplicate Room (19/9/2024)
    //         $idVcExists = ApplicationVc::where('application_id', $application->id)->exists();

    //         if ($idVcExists) {
    //             return redirect()->back()->with('errorMessage', 'Permohonan VC telah wujud');
    //         }else{

    //             // Tujuan : Tunggu kelulusan bilik terlebih dahulu
    //             if ($request->is_auto_input == 'Y') {
    //                 $status_vc = '1';
    //             } else {
    //                 $status_vc = '2';
    //             }

    //             $applicationVc = new ApplicationVc();
    //             $applicationVc->application_id = $application->id;
    //             $applicationVc->status_vc_id = $status_vc;
    //             $applicationVc->webex = $request->akaun_webex;
    //             $applicationVc->nama_aplikasi = $request->nama_aplikasi;
    //             $applicationVc->peralatan = $request->peralatan;
    //             $applicationVc->catatan = $request->catatan_vc;
    //             $applicationVc->created_at = now();
    //             $applicationVc->created_by = $id;
    //             $applicationVc->save();
    //         }
    //     }

    //     $data = array(
    //         'to' => $user->email,
    //         'subject' => 'Permohonan Tempahan Bilik/VC Untuk Kelulusan',
    //         'id' => $application->id,
    //         'nama_mesyuarat' => $application->nama_mesyuarat,
    //         'bilik' => $application->room->nama,
    //         'tarikh_mula' => $application->tarikh_mula,
    //         'tarikh_hingga' => $application->tarikh_hingga,
    //         'nama_pengerusi' => $application->nama_pengerusi,
    //         'bilangan_tempahan' => $application->bilangan_tempahan,
    //     );
    //     Mail::send(['html' => 'emails.permohonan_baru'], $data, function ($message) use ($data) {
    //         $message->subject($data['subject']);
    //         $message->to($data['to']);
    //         $message->from('eTempah@miti.gov.my', "eTempah");
    //     });

    //     $application_id = $application->id;

    //     $msg = 'Permohonan tempahan anda telah dihantar untuk diproses.';

    //     return redirect('/application/show/' . encrypt($application_id))->with('successMessage', $msg);
    // }

    public function cancel(Request $request, Application $application)
    {
        // return $application->applicationRoom;
        $id = Auth::id();
        $user =  User::find($id);
        $room_users = Room::find($application->room_id)->users;
        $supervisorsRooms_email = $room_users->pluck('email')->toArray();

        if (!empty($application->applicationRoom) && !empty($application->applicationVc)) {
            $tempahan = 'bilik dan VC';
        } elseif (!empty($application->applicationRoom)) {
            $tempahan = 'bilik';
        } elseif (!empty($application->applicationVc)) {
            $tempahan = 'VC';
        }

        // $tarikh_mula = date('d-m-Y g:i A', strtotime($application->tarikh_mula));
        // $tarikh_hingga = date('d-m-Y g:i A', strtotime($application->tarikh_hingga));

        $applications = Application::where('batch_id', $application->batch_id)->get();

        //Update status
        foreach ($applications as $app) {
            if ($request->act == 'batal_room_vc') { //status Bilik = Baru, Vc = Draf

                if (!empty($app->applicationRoom)) {
                    $app->applicationRoom->status_room_id = '7';
                    $app->applicationRoom->save();
                }

                if (!empty($app->applicationVc)) {
                    $app->applicationVc->status_vc_id = '5'; // contoh
                    $app->applicationVc->save();
                }
            }
            elseif ($request->act == 'batal_vc') {

                if (!empty($app->applicationVc)) {
                    $app->applicationVc->status_vc_id = '5';
                    $app->applicationVc->save();
                }

            }
            elseif ($request->act == 'batal_room') {

                if (!empty($app->applicationRoom)) {
                    $app->applicationRoom->status_room_id = '7';
                    $app->applicationRoom->save();
                }

            }
            elseif ($request->act == 'mohon_batal') {

                if (!empty($app->applicationRoom)) {
                    $app->applicationRoom->status_room_id = '3';
                    $app->applicationRoom->save();
                }
                if (!empty($app->applicationVc)) {
                    if ($app->applicationVc->status_vc_id == '1' || $app->applicationVc->status_vc_id == '2' || $app->applicationVc->status_vc_id == '3' || $app->applicationVc->status_vc_id == '12') {
                        $app->applicationVc->status_vc_id = '5';
                        $app->applicationVc->save();
                    }
                }
            }
        }
        //End update status

        //collect data
        $applicationfirst =  Application::where('id', $application->id)->first();

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

        if ($request->act == 'batal_room_vc') { //status Bilik = Baru, Vc = Draf

            // $application->applicationRoom->status_room_id = '7';
            // $application->applicationRoom->save();

            // $application->applicationVc->status_vc_id = '5';
            // $application->applicationVc->save();
            $msg = 'Pembatalan telah berjaya dikemaskini.';

            $subject_pemohon = 'Makluman: Pembatalan Tempahan ' . $application->room->nama;
            $subject_penyelia = 'Makluman: Pembatalan Tempahan ' . $application->room->nama;
            $action_pemohon = 'dibatalkan oleh pemohon';
            $action_penyelia = 'telah dibatalkan oleh pemohon';
            $action_penyelia2 = '';
            $status_bilik = $applicationfirst->applicationRoom->statusRoom->status_pemohon;
            $status_bilik_id = $applicationfirst->applicationRoom->status_room_id;
            $catatan_room = $applicationfirst->applicationRoom->catatan;
            $catatan_room_penyelia = $applicationfirst->applicationRoom->catatan_penyelia;

        } elseif ($request->act == 'batal_vc') {

            // $application->applicationVc->status_vc_id = '5';
            // $application->applicationVc->save();
            $msg = 'Pembatalan telah berjaya dikemaskini.';
            $subject_pemohon = 'Makluman: Pembatalan Tempahan VC di ' . $application->room->nama;
            $subject_penyelia = 'Makluman: Pembatalan Tempahan VC di ' . $application->room->nama;
            $action_pemohon = 'dibatalkan oleh pemohon';
            $action_penyelia = 'telah dibatalkan oleh pemohon';
            $action_penyelia2 = '';
            $status_bilik = '';
            $status_bilik_id = '';
            $catatan_room = '';
            $catatan_room_penyelia = '';
        } elseif ($request->act == 'batal_room') {

            // $application->applicationRoom->status_room_id = '7';
            // $application->applicationRoom->save();
            $msg = 'Pembatalan telah berjaya dikemaskini.';
            $subject_pemohon = 'Makluman: Pembatalan Tempahan ' . $application->room->nama;
            $subject_penyelia = 'Makluman: Pembatalan Tempahan ' . $application->room->nama;
            $action_pemohon = 'dibatalkan oleh pemohon';
            $action_penyelia = 'telah dibatalkan oleh pemohon';
            $action_penyelia2 = '';
            $status_bilik = $applicationfirst->applicationRoom->statusRoom->status_pemohon;
            $status_bilik_id = $applicationfirst->applicationRoom->status_room_id;
            $catatan_room = $applicationfirst->applicationRoom->catatan;
            $catatan_room_penyelia = $applicationfirst->applicationRoom->catatan_penyelia;
        } elseif ($request->act == 'mohon_batal') {

            // $application->applicationRoom->status_room_id = '3';
            // $application->applicationRoom->save();

            $msg = 'Permohonan Pembatalan telah berjaya dikemaskini.';
            $subject_pemohon = 'Makluman: Permohonan Pembatalan Tempahan ' . $application->room->nama;
            $subject_penyelia = 'Tindakan: Permohonan Pembatalan Tempahan ' . $application->room->nama;
            $action_pemohon = 'dihantar untuk tindakan Pentadbir';
            $action_penyelia = 'untuk tindakan';
            $action_penyelia2 = 'pembatalan';
            $status_bilik = $applicationfirst->applicationRoom->statusRoom->status_pemohon;
            $status_bilik_id = $applicationfirst->applicationRoom->status_room_id;
            $catatan_room = $applicationfirst->applicationRoom->catatan;
            $catatan_room_penyelia = $applicationfirst->applicationRoom->catatan_penyelia;

            // if (!empty($application->applicationVc)) {
            //     if ($application->applicationVc->status_vc_id == '1' || $application->applicationVc->status_vc_id == '2' || $application->applicationVc->status_vc_id == '3' || $application->applicationVc->status_vc_id == '12') {
            //         $application->applicationVc->status_vc_id = '5';
            //         $application->applicationVc->save();
            //     }
            // }
        }
        $nama_pengerusi = $application->nama_pengerusi ?? $application->kategori_pengerusi;

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
        $peralatan = '';

        if (!empty($application->applicationVc)) {
            $webex = $application->applicationVc->webex;
            $peralatan = $application->applicationVc->peralatan;
            $apply_vc = 1;
            $status_vc_id = $applicationfirst->applicationVc->status_vc_id;
            $status_vc = $applicationfirst->applicationVc->statusVc->status_pemohon;
            $catatan_penyelia_vc = $applicationfirst->applicationVc->catatan_penyelia;

            if ($peralatan == 1) {
                $peralatan = 'YA';
            } else {
                $peralatan = 'TIDAK';
            }

            if ($webex == 1) {
                $webex = 'YA';
                $nama_aplikasi = '';
                $link_webex = $applicationfirst->applicationVc->link_webex;
                $id_webex = $applicationfirst->applicationVc->id_webex;
                $password_webex = $applicationfirst->applicationVc->password_webex;
                $password_expired = date('d-m-Y g:i A', strtotime($applicationfirst->applicationVc->password_expired));
                $catatan_vc = $applicationfirst->applicationVc->catatan;
            } else {
                $webex = 'TIDAK';
                $nama_aplikasi = $applicationfirst->applicationVc->nama_aplikasi;
                $catatan_vc = $applicationfirst->applicationVc->catatan;
            }
            $link_webex = $applicationfirst->applicationVc->link_webex;
            $id_webex = $applicationfirst->applicationVc->id_webex;
        } else {
            $apply_vc = 0;
            $status_vc_id = '';
        }

        $email_penyeliaVc = User::role('approver-vc')->pluck('email')->toArray();

        $data = array(
            'to_pemohon' => $user->email,
            'tempahan' => $tempahan,
            'to_penyelia' => $supervisorsRooms_email,
            'to_penyelia_vc' => $email_penyeliaVc,
            'subject_pemohon' => $subject_pemohon,
            'subject_penyelia' => $subject_penyelia,
            'subject_penyelia_vc' => 'Makluman: Pembatalan Tempahan VC di ' . $application->room->nama,
            'action_pemohon' => $action_pemohon,
            'action_penyelia' => $action_penyelia,
            'action_penyelia2' => $action_penyelia2,
            'action_penyelia_vc' => 'telah dibatalkan oleh Pemohon',
            'id' => $applicationfirst->id,
            'batch_id' => $applicationfirst->batch_id,
            'nama_pemohon' => $user->name,
            'bahagian_pemohon' => $user->profile->department->nama,
            'nama_mesyuarat' => $application->nama_mesyuarat,
            'bilik' => $application->room->nama,
            'status_bilik' => $status_bilik,
            'status_bilik_id' => $status_bilik_id,
            'senarai_tarikh' => $senarai_tarikh,
            'nama_pengerusi' => $nama_pengerusi,
            'bilangan_tempahan' => $applicationfirst->bilangan_tempahan,
            'catatan_room' => $catatan_room,
            'catatan_room_penyelia' => $catatan_room_penyelia,
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
            'vc_komen_ditolak' => '',
        );

        if (!empty($applicationfirst->applicationVc)) {
            if (!empty($applicationfirst->applicationRoom)) {
                if ($applicationfirst->applicationRoom->status_room_id == '3') {

                    //bila penyelia bilik luluskan bilik, status vc akan bertukar kepada dalam proses.  So email perlu dihantar kpd penyelia vc.
                    Mail::send(['html' => 'emails.penyelia_vc'], $data, function ($message) use ($data) {
                        $message->subject($data['subject_penyelia_vc']);
                        $message->to($data['to_penyelia_vc']);
                        $message->from('eTempah@miti.gov.my', "eTempah");
                    });
                }
            } else { //kes pemohon batal vc sahaja
                Mail::send(['html' => 'emails.penyelia_vc'], $data, function ($message) use ($data) {
                    $message->subject($data['subject_penyelia_vc']);
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

        if ($application->room->email_status == 'Y') {
            Mail::send(['html' => 'emails.penyelia'], $data, function ($message) use ($data) {
                $message->subject($data['subject_penyelia']);
                $message->to($data['to_penyelia']);
                $message->from('eTempah@miti.gov.my', "eTempah");
            });
        }

        $tag = session()->get('tag');

        return redirect('/application/' . $tag)->with('successMessage', $msg);
    }

    public function search()
    {
        $rooms = Room::orderBy('nama', 'ASC')->get();
        $id = Auth::id();
        $user = User::find($id);
        return view('applications.search', compact('rooms', 'user'));
    }

    public function search_result()
    {
        $rooms = Room::orderBy('nama', 'ASC')->get();
        return view('applications._output_search', compact('rooms'));
    }
}

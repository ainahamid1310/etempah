<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\ReportRequest;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

        $status_approved = ['2', '6', '11', '14'];

        $today =  Carbon::today()->format('Y-m-d H:i:s');
        $applications = Application::select('applications.*')
            ->distinct('nama_mesyuarat')
            ->join('application_rooms', 'application_rooms.application_id', '=', 'applications.id')
            ->leftJoin('reports', 'reports.application_id', '=', 'applications.id')
            // ->whereDate('reports.deleted_at', null)
            ->whereIn('status_room_id', $status_approved)
            ->where('user_id', $user_id)
            ->whereDate('tarikh_hingga', '<', $today)
            ->get();

        // return $reports = Report::select('applications.*')
        //     ->leftJoin('applications', 'reports.application_id', '=', 'applications.id')
        //     ->where('deleted_at', null)
        //     ->get();

        return view('aduan.index', compact('applications'));
    }

    public function create()
    {
        //modal in index & view
    }

    public function store(ReportRequest $request)
    {
        $report = new Report();
        $report->aduan = $request->aduan;
        $report->application_id = $request->applicationId;
        $report->cadangan = $request->cadangan;
        $report->created_by = Auth::user()->name;
        $report->save();

        $msg = 'Maklumat Aduan telah berjaya dihantar.';

        if ($request->appear == 'index') {
            return redirect('report/')->with('successMessage', $msg);
        } elseif ($request->appear == 'show') {
            return redirect('report/show/' . $report->application_id)->with('successMessage', $msg);
        }
    }

    public function edit($reportId)
    {
        $report = Report::find($reportId);
        $application = Application::find($report->application_id);

        return view('aduan.edit', compact('application'));
    }

    public function update(Request $request, $reportId)
    {
        $report = Report::find($reportId);
        $report->aduan = $request->aduan;
        $report->cadangan = $request->cadangan;
        $report->updated_by = Auth::user()->name;
        $report->updated_at = now();
        $report->save();

        $application = Application::find($report->application_id);
        $msg = 'Maklumat Aduan telah dikemaskini.';

        return redirect('/report/show/' . $application->id)->with('successMessage', $msg)->with('application', $application);
    }

    public function show($applicationId)
    {
        $application = Application::find($applicationId);
        return view('aduan.view', compact('application'));
    }

    public function destroy(Report $report)
    {
        $report->update(['deleted_by' => Auth::user()->name]);
        $report->delete();

        $msg = 'Maklumat Aduan telah dipadam.';

        return redirect('/report/show/' . $report->application_id)->with('successMessage', $msg);
    }
}

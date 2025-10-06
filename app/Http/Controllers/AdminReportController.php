<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Report;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function index()
    {

        $user = User::where('is_admin', 1)
            ->where('id', Auth::user()->id)
            ->first();

        //Bilik yang tiada pelulus
        if (!empty($user->id)) {
            $user_id = $user->id;
        } else {
            $user_id = '';
        }

        $role = $user->getRoleNames();

        if ($role == 'super-admin') {
            $rooms = '%';
        } else {
            // Bilik Penyelia
            $rooms = Room::whereHas('users', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->pluck('id')->toArray();
        }


        $reports = Report::Join('applications', 'applications.id', '=', 'reports.application_id')
            ->where('reports.deleted_at', NULL)
            ->whereIn('room_id', $rooms)->get();

        return view('admins.aduan.index', compact('reports'));
    }

    public function show($id)
    {
        $id = decrypt($id);
        $application = Application::find($id);
        return view('admins.aduan.view', compact('application'));
    }
}

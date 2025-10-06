<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Level;
use App\Models\Section;
use Illuminate\Http\Request;
use Mockery\Undefined;

class DependentDropdownController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        // return $departments;
        return view('demo.live_drop_down.index', compact('departments'));
    }

    public function searchSection($id)
    {
        $sections = Section::where('department_id', $id)->get();

        return response()->json($sections);
    }

    public function searchLevel($id)
    {
        $levels = Level::where('deparment_id', $id)->get();
        return response()->json($levels);
    }
}

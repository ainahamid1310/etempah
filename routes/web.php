<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationRoomController;
use App\Http\Controllers\ApplicationVcController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DependentDropdownController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexEventsController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicUserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/department2', [DependentDropdownController::class, 'index']);
Route::get('/searchSection/{id}', [DependentDropdownController::class, 'searchSection']);
Route::get('/searchLevel/{id}',[DependentDropdownController::class, 'searchLevel']);

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/'[HomeController::class,'welcome')->name('guest');


Route::get('/forbidden', function () {
    return view('403');
});

Auth::routes();

// Route::get('/login'[Auth\LoginController::class,'login');
// Route::get('/user/reset_password'[Auth\LoginController::class,'updatePassword');
Route::get('/logout',[LoginController::class,'logout']);

Route::get('/user',[UserController::class,'index']);
Route::get('/user/create',[UserController::class,'create']);
Route::post('/user/create',[UserController::class,'store']);
Route::get('/user/edit/{user}',[UserController::class,'edit']);
Route::post('/user/edit/{user}',[UserController::class,'update']);
Route::get('/user/show/{user}',[UserController::class,'show']);
Route::get('/user/destroy/{user}',[UserController::class,'destroy']);

Route::get('/user_public',  [PublicUserController::class, 'index']);
Route::get('/user_public/create', [PublicUserController::class, 'create']);
Route::post('/user_public/create', [PublicUserController::class, 'store']);

// Route::get('/user_public/create'[PublicUserController::class,'create');
// Route::post('/user_public/create'[PublicUserController::class,'store');
Route::post('/',[PublicUserController::class, 'store']);

Route::post('/user/reset_password/{user}',[UserController::class,'updatePassword']);

Route::group(
    ['middleware' => ['auth']],
    function () {
        // Pemohon
        Route::get('/user_public/edit/{user}',[PublicUserController::class, 'edit']);
        Route::post('/user_public/edit/{user}',[PublicUserController::class, 'update']);
        Route::get('/user_public/show/{user}',[PublicUserController::class, 'show']);
        Route::get('/user_public/destroy/{user}',[PublicUserController::class, 'destroy']);

        // Route::get('/home'[HomeController::class,'index')->name('home');
        Route::get('/home',  [HomeController::class, 'index'])->name('home');
        Route::get('/home/select/{layout}', [HomeController::class, 'view']);

        Route::get('/application/{tag}', [ApplicationController::class,'index']);
        Route::get('/application/applicant/create', [ApplicationController::class,'create']);
        Route::get('/application/recreate/{batch}', [ApplicationController::class,'recreate']);
        Route::get('/application/create_vc/{application}', [ApplicationController::class,'createvc']);
        Route::post('/application/create_vc/{application}', [ApplicationController::class,'storevc']);
        Route::post('/application/applicant/create', [ApplicationController::class,'store']);
        Route::get('/application/show/{application}', [ApplicationController::class,'show']);
        Route::get('/application/edit/{application}',[ApplicationController::class,'edit']);
        Route::post('/application/edit/{application}',[ApplicationController::class,'update']);
        Route::get('/application/destroy/{applicant}',[ApplicationController::class,'destroy']);

        Route::post('/check-availability', [ApplicationController::class, 'checkAvailability'])->name('check.availability');
        Route::get('/application/{batch}', [ApplicationController::class,'index']);        

        // Function Copy
        Route::get('/application/recreate/{application}',[ApplicationController::class,'recreate']);

        //Function Batal
        Route::post('/application/cancel/{application}',[ApplicationController::class,'cancel']);

        //JS for Availability Room
        Route::get('/application/room/check',[ApplicationController::class,'availabilityRoom']);

        Route::get('/application/room/{tag}',[ApplicationController::class,'index']);
        Route::get('/application/room/create',[ApplicationController::class,'create']);
        Route::get('/application/room/recreate/{application}',[ApplicationController::class,'recreate']);
        Route::post('/application/room/recreate/{application}',[ApplicationController::class,'restore']);
        Route::post('/application/room/create',[ApplicationController::class,'store']);
        Route::post('/application/room/show/{application}',[ApplicationController::class,'show']);

        Route::get('/profile',[ProfileController::class,'index']);
        Route::get('/profile/create',[ApplicationController::class,'index']);
        Route::post('/profile/create',[ProfileController::class,'store']);
        Route::get('/profile/edit/{profile}',[ProfileController::class,'edit']);
        Route::post('/profile/edit/{profile}',[ProfileController::class,'update']);
        Route::get('/profile/show/{profile}',[ProfileController::class,'show']);
        Route::get('/profile/destroy/{profile}',[ProfileController::class,'destroy']);

        //Aduan
        Route::get('/report',[ReportController::class,'index']);
        Route::get('/report/create',[ReportController::class,'create']);
        Route::post('/report/create',[ReportController::class,'store']);
        Route::get('/report/edit/{report}',[ReportController::class,'edit']);
        Route::post('/report/edit/{report}',[ReportController::class,'update']);
        Route::get('/report/show/{report}',[ReportController::class,'show']);
        Route::delete('/report/destroy/{report}',[ReportController::class,'destroy']);

        Route::get('/reference/room_applicant',[RoomController::class,'list']);
        Route::get('/reference/room_applicant/show/{room}',[RoomController::class,'show_applicant']);
        Route::get('/reference/room/show/{room}',[RoomController::class,'show']);

        // Route::middleware(['rolecheck:approver-room,super-admin'])->group(function () {
        //     Route::get('/admin', [AdminController::class, 'index']);
        // });

        Route::middleware([
            IsAdmin::class . ':approver-room,super-admin'
        ])->group(function () {
                Route::get('/reference/room',[RoomController::class,'index']);
                Route::get('/reference/room/create',[RoomController::class,'create']);
                Route::post('/reference/room/create',[RoomController::class,'store']);
                Route::get('/reference/room/edit/{room}',[RoomController::class,'edit']);
                Route::post('/reference/room/edit/{room}',[RoomController::class,'update']);
                Route::get('/reference/room/destroy/{room}',[RoomController::class,'destroy']);

                Route::get('/admin',[AdminController::class,'index']);
                Route::get('/admin/edit/{admin}',[AdminController::class,'edit']);
                Route::post('/admin/edit/{admin}',[AdminController::class,'update']);
                Route::get('/admin/show/{admin}',[AdminController::class,'show']);
                Route::get('/admin/destroy/{admin}',[AdminController::class,'destroy']);

                // Admin Approver -> Room
                Route::get('/admin/application_room/{status}',[ApplicationRoomController::class,'index']);
                Route::get('/admin/application_room/edit/{application_room}',[ApplicationRoomController::class,'edit']);
                Route::post('/admin/application_room/edit/{application_room}',[ApplicationRoomController::class,'update']);

                Route::get('/admin/application_room/edit_pantry/{application_room}',[ApplicationRoomController::class,'edit_pantry']);
                Route::post('/admin/application_room/edit_pantry/{application_room}',[ApplicationRoomController::class,'update_pantry']);
                Route::get('/admin/application_room/show/{application_room}',[ApplicationRoomController::class,'show']);
                Route::post('/admin/application_room/result/{batch_id}',[ApplicationRoomController::class,'result']);

                //Aduan Admin
                Route::get('/admin/report',[AdminReportController::class,'index']);
                Route::get('/admin/report/create',[AdminReportController::class,'create']);
                Route::post('/admin/report/create',[AdminReportController::class,'store']);
                Route::get('/admin/report/edit/{report}',[AdminReportController::class,'edit']);
                Route::post('/admin/report/edit/{report}',[AdminReportController::class,'update']);

                Route::get('/room_user',[RoomController::class,'index']);
                Route::get('/room_user/create',[RoomController::class,'create']);
                Route::post('/room_user/create',[RoomController::class,'store']);
                Route::get('/room_user/edit',[RoomController::class,'edit']);
                Route::post('/room_user/edit',[RoomController::class,'update']);
                Route::get('/room_user/show/{room}',[RoomController::class,'show']);
                Route::get('/room_user/destroy/{room}',[RoomController::class,'destroy']);

                Route::get('/reference/position',[PositionController::class,'index']);
                Route::get('/reference/position/create',[PositionController::class,'create']);
                Route::post('/reference/position/create',[PositionController::class,'store']);
                Route::get('/reference/position/edit/{position}',[PositionController::class,'edit']);
                Route::post('/reference/position/edit/{position}',[PositionController::class,'update']);
                Route::get('/reference/position/{position}',[PositionController::class,'show']);
                Route::delete('/reference/position/destroy/{position}',[PositionController::class,'destroy']);

                Route::get('/reference/department',[DepartmentController::class,'index']);
                Route::get('/reference/department/create',[DepartmentController::class,'create']);
                Route::post('/reference/department/create',[DepartmentController::class,'store']);
                Route::get('/reference/department/edit/{department}',[DepartmentController::class,'edit']);
                Route::post('/reference/department/edit/{department}',[DepartmentController::class,'update']);
                Route::get('/reference/department/show/{department}',[DepartmentController::class,'show']);
                Route::delete('/reference/department/destroy/{department}',[DepartmentController::class,'destroy']);
                Route::get('/admin/report/show/{report}',[AdminReportController::class,'show']);
                Route::delete('/admin/report/destroy/{report}',[AdminReportController::class,'destroy']);


                Route::get('/assign_role',[RoomController::class,'index']);
                Route::get('/assign_role/create',[RoomController::class,'create']);
                Route::post('/assign_role/create',[RoomController::class,'store']);
                Route::get('/assign_role/edit',[RoomController::class,'edit']);
                Route::post('/assign_role/edit',[RoomController::class,'update']);
                Route::get('/assign_role/show/{role}',[RoomController::class,'show']);
                Route::get('/assign_role/destroy/{room}',[RoomController::class,'destroy']);

                //Laporan Statistik
                Route::get('/laporan/statistik',[LaporanController::class,'statistik']);

                //Laporan Aduan
                Route::get('/laporan/aduan',[LaporanController::class,'aduan']);
        });

        Route::middleware([
            IsAdmin::class . ':approver-room,approver-vc,super-admin'
        ])->group(function () {
                Route::get('/announcement',[AnnouncementController::class,'index']);
                Route::get('/announcement/create',[AnnouncementController::class,'create']);
                Route::post('/announcement/create',[AnnouncementController::class,'store']);
                Route::get('/announcement/edit/{announcement}',[AnnouncementController::class,'edit']);
                Route::post('/announcement/edit/{announcement}',[AnnouncementController::class,'update']);
                Route::get('/announcement/show/{announcement}',[AnnouncementController::class,'show']);
                Route::delete('/announcement/destroy/{announcement}',[AnnouncementController::class,'destroy'])->name('announcement.delete');

                Route::get('/contact', [ContactController::class,'index']);
                Route::get('/contact/create', [ContactController::class,'create']);
                Route::post('/contact/create', [ContactController::class,'store']);
                Route::get('/contact/edit/{contact}', [ContactController::class,'edit']);
                Route::post('/contact/edit/{contact}', [ContactController::class,'update']);
                Route::get('/contact/show/{contact}', [ContactController::class,'show']);
                Route::get('/contact/destroy/{contact}', [ContactController::class,'destroy']);
                Route::delete('/contact/destroy/{contact}', [ContactController::class,'destroy'])->name('contact.delete');

            }
        );

        Route::middleware([
            IsAdmin::class . ':approver-vc|super-admin|approver-room'
        ])->group(function () {
                // Admin Approver -> VC
                Route::get('/admin/application_vc/{tag}',[ApplicationVcController::class,'index']);
                Route::get('/admin/application_vc/edit/{Application_vc}',[ApplicationVcController::class,'edit']);
                Route::post('/admin/application_vc/edit/{Application_vc}',[ApplicationVcController::class,'update']);
                Route::get('/admin/application_vc/show/{Application_vc}',[ApplicationVcController::class,'show']);
                Route::post('/admin/application_vc/result/{Application_vc}',[ApplicationVcController::class,'result']);
                Route::get('/admin/application_vc/destroy/{Application_vc}',[ApplicationVcController::class,'destroy']);

                //Laporan Vc
                Route::get('/laporan/vc',[LaporanController::class,'vc']);

                //Laporan Statistik
                Route::get('/laporan/statistik',[LaporanController::class,'statistik']);
            }
        );

        Route::middleware([
            IsAdmin::class . ':pmsb|super-admin'
        ])->group(function () {
                //Laporan PMSB
                Route::get('/laporan/pmsb',[LaporanController::class,'index']);
            }
        );


        Route::middleware([
            IsAdmin::class . ':biz-point|super-admin'
        ])->group(function () {
                //Laporan Biz Point
                Route::get('/laporan/biz',[LaporanController::class,'biz']);
            }
        );
    }
);

Route::middleware([
            IsAdmin::class . ':approver-vc|super-admin|biz-point|pmsb|approver-room'
        ])->group(function () {
        // Admin Approver -> VC
        //Laporan Tempahan Bilik Mesyuarat
        Route::get('/laporan/bilik',[LaporanController::class,'bilik']);
    }
);

// Route::group(
//     ['middleware' => ['super-admin']],
//     function () {
Route::middleware([
            IsAdmin::class . ':super-admin'
        ])->group(function () {

        Route::get('/role', [RoleController::class,'index']);
        Route::get('/role/create',[RoleController::class,'create']);
        Route::post('/role/create',[RoleController::class,'store']);
        Route::get('/role/edit/{role}',[RoleController::class,'edit']);
        Route::post('/role/edit/{role}',[RoleController::class,'update']);
        Route::get('/role/show/{role}',[RoleController::class,'show']);
        Route::get('/role/destroy/{room}',[RoleController::class,'destroy']);
    }
);
//Home Calendar
// Route::get('/events', function () {
//     return view('welcome_events');
// });
Route::get('/events',[IndexEventsController::class,'events'])->name('events');
Route::get('/events/show',[IndexEventsController::class,'showevents'])->name('homevents');
Route::get('/events/{id}/{val}',[IndexEventsController::class,'modalshow'])->name('modal_show');

//Calendar
Route::get('/program',[HomeController::class,'indexshow'])->name('agendashow');
Route::get('/program/{id}',[HomeController::class,'modalshow'])->name('modalview');

Route::get('/pengguna/program',[HomeController::class,'penggunashow'])->name('penggunashow');
Route::get('/pengguna/program/{id}',[HomeController::class,'modalpenggunashow'])->name('penggunaview');

//carian tempahan
// Route::get('/carian/tempahan/{layout}',[LaporanController::class,'tempahan');
Route::get('/cari/tempahan/{layout}',[LaporanController::class,'tempahan']);

//Hubungi Kami
// Route::get('/',[ContactController::class,'hubungikami');
// Route::get('/events',[ContactController::class,'events');

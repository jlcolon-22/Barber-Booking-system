<?php

use App\Http\Controllers\API\admin\AdminDashboardController;
use App\Http\Controllers\API\OwnerController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages.welcome');
});
Route::get('/contact', function () {
    return view('pages.contact');
});
Route::get('/booked', function () {
    return view('pages.booked');
});
Route::get('/about', function () {
    return view('pages.about');
});
Route::get('/verified/message', function () {
    return view('pages.message');
});
Route::get('/auth/forget', function () {
    return view('auth.forget');
});
Route::get('/auth/forget/message', function () {
    return view('auth.forgetmessage');
});
Route::middleware('customer.only')->group(function () {
    Route::get('/reservation', [FrontendController::class, 'reservation']);
    Route::post('/reservation', [FrontendController::class, 'store_reservation']);
    Route::get('/appointment', [FrontendController::class, 'appointment']);
    Route::get('/appointment/{id}', [FrontendController::class, 'update_appointment']);
    Route::get('/account', [FrontendController::class, 'account']);
    Route::post('/account/{id}', [FrontendController::class, 'update_account']);

    //message
    Route::post('/message/{branch_id}', [FrontendController::class, 'create_message'])->name('create_message');
    Route::get('/message/convo/{branch_id}', [FrontendController::class, 'view_convo'])->name('view_convo');
    Route::post('/message/convo/{branch_id}', [FrontendController::class, 'view_convo_store'])->name('view_convo_store');
    Route::get('/all/message/{branch_id}', [FrontendController::class, 'fetch_message'])->name('fetch_message');
    Route::get('/message', [FrontendController::class, 'meessage']);
    Route::post('/admins/message/', [FrontendController::class, 'admin_message_store'])->name('admin_message_store');
    Route::get('/admins/message', [FrontendController::class, 'admin_message_fetch'])->name('admin_message_fetch');
});

Route::post('/contact', [FrontendController::class, 'contact']);
Route::post('/branch/time/{id}',[FrontendController::class,'getBranchTIme']);


Route::get('/services', [FrontendController::class, 'services']);
Route::post('/services/branch/{branch_id}',[FrontendController::class,'getBranchDate']);
Route::get('/view', [FrontendController::class, 'branch']);
Route::post('/feedback', [FrontendController::class, 'feedback']);

// auth
Route::get('/auth/login', [AuthController::class, 'index'])->middleware('auth.only');
Route::post('/auth/login', [AuthController::class, 'userLogin']);
Route::get('/auth/signup', [AuthController::class, 'signup'])->middleware('auth.only');
Route::post('/auth/signup', [AuthController::class, 'store_signup']);
Route::get('/auth/verification/{id}', [AuthController::class, 'verified']);
Route::get('/auth/google', [AuthController::class, 'signup_google']);
Route::get('/auth/google/callback', [AuthController::class, 'google_callback']);
Route::get('/auth/logout', [AuthController::class, 'userLogout']);
Route::post('/auth/forget', [AuthController::class, 'forget']);
Route::get('/auth/password/reset/{id}', [AuthController::class, 'password']);
Route::post('/auth/password/reset/{id}', [AuthController::class, 'reset_password']);


// admin
Route::middleware(['admin.only'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::get('appointment', [AdminDashboardController::class, 'appointment']);
    Route::get('/account', [AdminDashboardController::class, 'account']);
    Route::get('/branch', [AdminDashboardController::class, 'branch']);

    Route::post('/branch', [AdminDashboardController::class, 'store_branch']);
    Route::get('/branch/delete/{id}', [AdminDashboardController::class, 'delete_branch']);
    Route::post('/branch/{id}', [AdminDashboardController::class, 'update_branch']);
    Route::post('/account', [AdminDashboardController::class, 'store_account']);
    Route::post('/account/{id}', [AdminDashboardController::class, 'update_account']);

    // message
    Route::get('/message',[AdminDashboardController::class, 'message']);
    Route::get('/message/convo/{convoId}', [AdminDashboardController::class, 'view_message']);
    Route::get('/all/message/{branch_id}', [AdminDashboardController::class, 'owner_fetch_message']);
    Route::post('/message/convo/{branch_id}', [AdminDashboardController::class, 'admin_store_message']);

    // reports
    Route::get('/reports', [AdminDashboardController::class, 'reports']);
    Route::post('/reports', [AdminDashboardController::class, 'get_reports']);
});

// Owner
Route::middleware('owner.only')->prefix('owner')->group(function () {

    Route::get('dashboard', [OwnerController::class, 'index']);
    Route::get('appointment', [OwnerController::class, 'appointment']);
    Route::get('account', [OwnerController::class, 'account']);
    Route::get('certificate', [OwnerController::class, 'certificate']);
    Route::post('certificate', [OwnerController::class, 'store_certificate']);
    Route::get('certificate/delete/{id}', [OwnerController::class, 'delete_certificate']);
    Route::get('posts', [OwnerController::class, 'posts']);
    Route::post('posts', [OwnerController::class, 'store_post']);
    Route::post('post/{id}', [OwnerController::class, 'update_post']);
    Route::post('account', [OwnerController::class, 'store_account']);
    Route::post('/account/{id}', [OwnerController::class, 'update_account']);
    Route::get('/appointment/{id}/approved', [OwnerController::class, 'update_appointment']);
    Route::get('/appointment/{id}/cancel', [OwnerController::class, 'cancel_appointment']);
    Route::get('/post/delete/{id}', [OwnerController::class, 'post_delete']);
    Route::get('/account/delete/{id}', [OwnerController::class, 'account_delete']);
    Route::get('/message/convo/{convoId}', [OwnerController::class, 'view_message']);
    Route::get('/message', [OwnerController::class, 'messages']);
    Route::post('/message/convo/{branch_id}', [OwnerController::class, 'owner_store_message'])->name('owner_store_message');
    Route::get('/all/message/{branch_id}', [OwnerController::class, 'owner_fetch_message'])->name('owner_fetch_message');
});


Route::middleware('employee.only')->prefix('employee')->group(function () {

    Route::get('appointment', [EmployeeController::class, 'appointment']);
    Route::get('/appointment/{id}/done', [EmployeeController::class, 'update_appointment']);
});



<?php

use App\Models\CompanyList;
use App\Models\User;
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
    return view('notification-test');
    // return view('welcome');
});

Route::get('/test', function () {
    event(new \App\Events\SendMessage());
    echo 'Event Run Successfully.';
});

Route::get('/testing', function () {
    $user = User::find(1);
    event(new \App\Events\NotifyUser($user));
    echo 'Event Run Successfully.';
});

Route::get('/notify/{companyId?}', function ($companyId = 1) {
    echo $company = CompanyList::find($companyId);
    event(new \App\Events\NotifyCompanySubscriber($company));
    echo 'Event Run Successfully.';
});

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'loginIndex'])->name('login'); //display login form...
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'checkLogin'])->name('login.post.check'); //Login form Post Check Credentials...
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout'); //Login form Post Check Credentials...


Route::get('/group', function () {
    return view('group-notification-PresenceChannel');
    // return view('welcome');
});

Route::get('/group/notify/{companyId?}', function ($companyId = 1) {
    echo $company = CompanyList::find($companyId);
    // event(new \App\Events\CompanySubscriberRoom($company));
    broadcast(new \App\Events\CompanySubscriberRoom($company))->toOthers();
    echo 'Event Run Successfully.';
});
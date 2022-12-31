<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('/scenario', App\Http\Controllers\ScenarioController::class);
Route::resource('/actor', App\Http\Controllers\ActorController::class);

Route::get('/laboratorynorms', [App\Http\Controllers\LaboratoryNormController::class, 'index'])->name('laboratorynorms.index');
Route::post('/laboratorynormajx', [App\Http\Controllers\LaboratoryNormController::class, 'updateajax'])->name('laboratorynorms.updateajax');
Route::get('/laboratorynormajx', [App\Http\Controllers\LaboratoryNormController::class, 'getajax'])->name('laboratorynorms.getajax');




/////////////////////////////////////////////////////////
//   U S E R
/////////////////////////////////////////////////////////




Route::get('mainprofile', [
  'uses' => 'App\Http\Controllers\UserController@mainprofile',
  'as' => 'user.mainprofile'
]);

Route::get('users/{type}', [
  'uses' => 'UserController@users',
  'as' => 'user.userlist'
]);

Route::get('user/{user_id}', [
  'uses' => 'UserController@userprofile',
  'as' => 'user.profile'
]);

Route::post('user/change', [
  'uses' => 'App\Http\Controllers\UserController@change',
  'as' => 'user.change'
]);

Route::get('/changePasswordForm','App\Http\Controllers\UserController@showChangePasswordForm')->name('changePasswordForm');
Route::post('/changePassword','App\Http\Controllers\UserController@changePassword')->name('changePassword');
Route::post('/ajaxusernotify', 'App\Http\Controllers\UserController@ajax_update_notify')->name('ajaxusernotify');



require __DIR__.'/auth.php';

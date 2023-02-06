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
  if (
    (Auth::user()->hasRoleCode('scene_doctor')) ||
    (Auth::user()->hasRoleCode('scene_nurse')) ||
    (Auth::user()->hasRoleCode('scene_midwife')) ||
    (Auth::user()->hasRoleCode('scene_paramedic'))
    )
    return Redirect::route('scene.index');
  else
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('/scenario', App\Http\Controllers\ScenarioController::class);
Route::resource('/actor', App\Http\Controllers\ActorController::class);
Route::resource('/scene', App\Http\Controllers\SceneController::class);
Route::resource('/sceneactor', App\Http\Controllers\SceneActorController::class);
Route::resource('/salaborder', App\Http\Controllers\SceneActorLabOrderController::class);



Route::post('/update_scenario_ajax', [App\Http\Controllers\ActorController::class, 'scenario_actor_save_ajax'])->name('actor.scenario_actor_save_ajax');
Route::get('/get_scenario_ajax', [App\Http\Controllers\ActorController::class, 'scenario_actor_get_ajax'])->name('actor.scenario_actor_get_ajax');

Route::get('/scenegetajax', [App\Http\Controllers\SceneController::class, 'get_scene_ajax'])->name('scene.get_scene_ajax');
Route::post('/sceneupdateajax', [App\Http\Controllers\SceneController::class, 'update_scene_ajax'])->name('scene.update_scene_ajax');

Route::post('/sceneactorsave', [App\Http\Controllers\SceneActorController::class, 'actor_scene_save_ajax'])->name('sceneactor.scene_actor_save_ajax');

Route::get('/saloajax', [App\Http\Controllers\SceneActorLabOrderController::class, 'get_salo_ajax'])->name('salaborder.get_salo_ajax');


Route::get('/laboratorynorms', [App\Http\Controllers\LaboratoryNormController::class, 'index'])->name('laboratorynorms.index');
Route::get('/laboratorynormajx', [App\Http\Controllers\LaboratoryNormController::class, 'get_laboratory_normm_ajax'])->name('laboratorynorms.get_laboratory_normm_ajax');
Route::get('/laboratorynormtemplate/{template_id}', [App\Http\Controllers\LaboratoryNormController::class, 'template_show'])->name('laboratorynorm.template');
Route::post('/laboratorynormajx', [App\Http\Controllers\LaboratoryNormController::class, 'update_laboratory_norm_ajax'])->name('laboratorynorms.update_laboratory_norm_ajax');
Route::post('/laboratorytemplateajx', [App\Http\Controllers\LaboratoryNormController::class, 'update_laboratory_norm_template_ajax'])->name('laboratorytemplate.update_laboratory_norm_ajax');
Route::post('/laboratorytemplate', [App\Http\Controllers\LaboratoryNormController::class, 'templateupdate'])->name('laboratorytemplate.update');


/////////////////////////////////////////////////////////
//   U S E R
/////////////////////////////////////////////////////////




Route::get('mainprofile', [
  'uses' => 'App\Http\Controllers\UserController@mainprofile',
  'as' => 'user.mainprofile'
]);

Route::get('users/{type}', [
  'uses' => 'App\Http\Controllers\UserController@users',
  'as' => 'user.userlist'
]);

Route::get('user/{user_id}', [
  'uses' => 'App\Http\Controllers\UserController@userprofile',
  'as' => 'user.profile'
]);

Route::post('user/change', [
  'uses' => 'App\Http\Controllers\UserController@change',
  'as' => 'user.change'
]);

Route::get('/changePasswordForm','App\Http\Controllers\UserController@showChangePasswordForm')->name('changePasswordForm');
Route::post('/changePassword','App\Http\Controllers\UserController@changePassword')->name('changePassword');
Route::post('/ajaxusernotify', 'App\Http\Controllers\UserController@ajax_update_notify')->name('ajaxusernotify');


/*  FOR TEST ONLY BEGIN  */
Route::get('/testuj', 'App\Http\Controllers\TestController@index')->name('testuj');
Route::get('/testuj2', 'App\Http\Controllers\TestController@index2')->name('testuj2');

Route::post('testuj/ajx_roomstorages', 'App\Http\Controllers\TestController@ajx_room_storages')->name('testuj.ajx_roomstorages');
Route::post('testuj/ajx_shelf_count', 'App\Http\Controllers\TestController@ajx_shelf_count')->name('testuj.ajx_shelf_count');
/*  FOR TEST ONLY END  */


require __DIR__.'/auth.php';

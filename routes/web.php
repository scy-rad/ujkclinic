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
// Route::resource('/laboratorynorms', App\Http\Controllers\LaboratoryNormController::class);  // change to index only


Route::get('/laboratorynorms', [App\Http\Controllers\LaboratoryNormController::class, 'index'])->name('laboratorynorms.index');
Route::post('/laboratorynormajx', [App\Http\Controllers\LaboratoryNormController::class, 'updateajax'])->name('laboratorynorms.updateajax');
Route::get('/laboratorynormajx', [App\Http\Controllers\LaboratoryNormController::class, 'getajax'])->name('laboratorynorms.getajax');

require __DIR__.'/auth.php';

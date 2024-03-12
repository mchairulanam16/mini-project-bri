<?php

use Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CodeController;
use Illuminate\Support\Facades\Auth;

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
    return redirect()->route('home');
});

Auth::routes();
//home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//user
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::post('/add-user', [App\Http\Controllers\UserController::class, 'store'])->name('user.add');
//Code
Route::get('/code', [App\Http\Controllers\CodeController::class, 'index'])->name('code');
Route::get('/generate-code', [App\Http\Controllers\CodeController::class, 'store'])->name('generateCode');
//Kelas
Route::get('/class', [App\Http\Controllers\KelasController::class, 'index'])->name('class');
Route::post('/add-class',  [App\Http\Controllers\KelasController::class, 'store'])->name('class.add');
//Absen
Route::post('/absence', [App\Http\Controllers\AbsenceController::class, 'store'])->name('checkin');
Route::post('/absence-out', [App\Http\Controllers\AbsenceController::class, 'update'])->name('checkout');
//Subject
Route::get('/subject', [App\Http\Controllers\SubjectController::class, 'index'])->name('subject');
Route::post('/subject-add', [App\Http\Controllers\SubjectController::class, 'store'])->name('subject.add');

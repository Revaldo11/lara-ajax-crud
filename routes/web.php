<?php

use App\Http\Controllers\StudentController;
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

// Route::get('/students', [StudentController::class, 'index'])->name('students.index');
// Route::post('/students', [StudentController::class, 'store'])->name('students.store');
// Route::get('/students/{id}', [StudentController::class, 'edit'])->name('students.edit');
// Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
// Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

Route::resource('students', StudentController::class);

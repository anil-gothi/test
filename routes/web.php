<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

Route::get('/', [Controller::class,'event_index']);
Route::post('/add-update-event', [Controller::class,'add_update_event'])->name('add_update_event_form');
Route::post('/edit-event', [Controller::class,'edit_event'])->name('edit_event');
Route::post('/delete-event', [Controller::class,'delete_event'])->name('delete_event');

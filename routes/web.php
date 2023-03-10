<?php

use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/', WelcomeController::class);

Route::resource('/contacts', ContactController::class);
Route::resources([
    '/companies' => CompanyController::class,
    '/tags' => TagController::class,
    '/tasks' => TaskController::class,
]);
Route::resource('/activities', ActivityController::class)->except(['index', 'show'])->parameters(
    [
        'activities' => 'active'
    ]
);
Route::resource('/contacts.notes', ContactNoteController::class)->shallow();




Route::get('/companies/{name?}', function ($name = null) {
    if ($name == null) {
        return view('companies');
    }
    return "<h1>Company $name</h1>";
})->where('name', '[a-zA-Z]+');
//whereAlpha('name');
//whereAlphaNumeric('name'); if we want to use numbers and letters

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

Route::controller(ContactController::class)->prefix('contacts')->name('contacts.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');
    Route::get('/{id}', 'show')->name('show')->where('id', '[0-9]+');
});

Route::resources([
    '/companies' => CompanyController::class,
    '/tags' => TagController::class,
    '/tasks' => TaskController::class,
]);
// Route::resource('/activities', ActivityController::class)->names(
//     [
//         'index' => 'activities.all',
//         'show' => 'activities.view',
//     ]
// );
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

Route::fallback(function () {
    return "<h1>Page not found</h1>";
});

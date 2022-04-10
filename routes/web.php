<?php

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
    // return redirect('/admin/profile');
    return view('welcome');
});

Route::get('/compartir/{id}', function ($id) {
    $reunion = App\Teletrabajo::find($id);
    
    return  redirect("https://api.whatsapp.com/send?&text=Reunion%0A".setting('site.link').$reunion->slug);
})->name('compartir');

//reunioines
Route::group(['middleware' => 'auth'], function () {
    Route::get('/reunion/{slug}', function ($slug) {
        $reunion = App\Teletrabajo::where('slug', $slug)->first();
        $participantes = App\RelTeleUser::where('teletrabajo_id', $reunion->id)->get();
        $name = $reunion->name;
        return view('reunion', compact('name', 'reunion'));
    })->name('reunion');
});

// auth
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/documentos/ver/{id}', function ($id) {
        return view('documentos.miview', compact('id'));
    })->name('miview');
});
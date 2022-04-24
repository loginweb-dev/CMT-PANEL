<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
    return redirect('/admin/profile');
    // return view('welcome');
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

    Route::post('/convocatorias/multiple', function (Request $request) {
        $files = $request->file('miconvocatorias');
        foreach($files as $file){
            $newfile =  Storage::disk('public')->put('convocatorias', $file);
            $comv = App\Convocatoria::create([
                'name'=> $file->getClientOriginalName(),
                'categoria_id' => $request->categoria_id,
                'editor_id' => $request->editor_id,
                'gestion' => $request->gestion,
                'file' => $newfile
            ]);
        }
        return redirect('admin/convocatorias');
    })->name('multiple_convocatorias');

    Route::post('/gacetas/multiple', function (Request $request) {
        $files = $request->file('migacetas');
        foreach($files as $file){
            $newfile =  Storage::disk('public')->put('gacetas', $file);
            $comv = App\Gaceta::create([
                'name'=> $file->getClientOriginalName(),
                'categoria_id' => $request->categoria_id,
                'editor_id' => $request->editor_id,
                'gestion' => $request->gestion,
                'file' => $newfile
            ]);
        }
        return redirect('admin/gacetas');
    })->name('multiple_gacetas');

});

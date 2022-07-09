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

//paginas ----------------------
Route::get('/resena-historica', function () {
    return view('paginas.resena-historica');
});

Route::get('/biblioteca-legislativa', function () {
    return view('paginas.biblioteca-legislativa');
});

Route::get('/estructura-del-concejo', function () {
    $concejales = App\Concejale::all();
    return view('paginas.estructura-del-concejo', compact('concejales'));
});

Route::get('/convocatorias-publicas', function () {
    $concejales = App\Concejale::all();
    return view('paginas.convocatorias-publicas', compact('concejales'));
});

Route::get('/publicaciones-oficiales', function () {
    $concejales = App\Concejale::all();
    return view('paginas.publicaciones-oficiales', compact('concejales'));
});

Route::get('/teletrabajo', function () {
    $concejales = App\Concejale::all();
    return view('paginas.teletrabajo', compact('concejales'));
});

Route::get('/reglamento-general', function () {
    $reglamento = App\Reglamento::find(1);
    return view('paginas.reglamento-general', compact('reglamento'));
});

// auth -------
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

Route::post('/respuesta/documento', function (Request $request) {
    //return $documento_id;
    $imagenes = $request->file('images_respuesta');
    $vector_img=[];
    if ($imagenes!= null) {
        foreach($imagenes as $file){
            $newfile =  Storage::disk('public')->put('documentos', $file);
            array_push($vector_img, $newfile);
        }
    }
    $vector_pdf=[];
    $pdfs = $request->file('pdf_respuesta');
    if ($pdfs!=null) {
        foreach($pdfs as $file){
            $newfile =  Storage::disk('public')->put('documentos', $file);
            array_push($vector_pdf, $newfile);
        }
    }

    $doc_detalle = App\DocumentoDetalle::create([
        'documento_id'=>$request->documento_id,
        'user_id'=>$request->user_id,
        'mensaje'=>$request->mensaje_respuesta,
        'image'=>json_encode($vector_img), 
        'pdf'=>json_encode($vector_pdf),
        'destinatario_interno'=>$request->destinatario_interno,
        'destinatario_externo'=>$request->destinatario_externo
    ]);

    return redirect('admin/documentos');
    
})->name('respuesta_documento');
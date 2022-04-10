<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Models\User;
use App\Persona;
use App\Categoria;
use App\Documento;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// TODAS LOS USER
Route::get('users', function () {
    return  User::all();
});

//Todas las personas
Route::get('personas', function () {
    return  Persona::all();
});

//Todas las categorias
Route::get('categorias', function () {
    return  Categoria::all();
});

//

Route::get('documentos/save/{midata}', function($midata) {
    $midata2 = json_decode($midata);
    $documento = Documento::create([
        'name' => $midata2->name,
        'description'=>$midata2->description,
        'estado_id'=>$midata2->estado_id,
        'categoria_id'=>$midata2->categoria_id,
        'persona_id'=>$midata2->persona_id,
        //'archivo'=>$midata2->archivo,
        'tipo'=>$midata2->tipo,
        'user_id'=>$midata2->user_id,
        'editor_id'=>$midata2->editor_id

    ]);
    return $documento;
});


//Derivar
Route::get('derivar/{midata}', function ($midata) {
    $midata2 = json_decode($midata);
    $documento = Documento::find($midata2->documento_id);
    $documento->estado_id = $midata2->estado_id;
    $documento->save();

    return $documento;
});
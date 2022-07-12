<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Models\User;
use App\Persona;
use App\Categoria;
use App\Documento;
use App\Convocatoria;
use App\CatConvocatoria;

use App\Gaceta;
use App\CatGaceta;
use App\DocumentoDetalle;
use App\RelDerivDoc;
use App\Pregunta;
use App\Concejale;
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

//Buscar un Usuario
Route::get('find/user/{id}', function($id){
    return User::find($id);
});

//Buscar una Persona
Route::get('find/persona/{id}', function($id){
    return Persona::find($id);
});

//Todas las personas
Route::get('personas', function () {
    return  Persona::all();
});

//Todas las categorias
Route::get('categorias', function () {
    return  Categoria::all();
});

//Todos los estados
Route::get('estados', function () {
    return  Estado::all();
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
        'editor_id'=>$midata2->editor_id,
        'remitente_id_interno'=>$midata2->remitente_id_interno,
        'remitente_id_externo'=>$midata2->remitente_id_externo

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

// //Responder
// Route::post('responder', function (Request $request) {
//     $documento = Documento::find($request->documento_id);
//     $documento->estado_id = 3;
//     $documento->save();
//     $detalle = DocumentoDetalle::create([
//         'documento_id' => $request->documento_id,
//         'user_id' => $request->user_id,
//         'mensaje' => $request->mensaje
//     ]);
//     return true;
// });
//Rechazar
// Route::post('rechazar', function (Request $request) {
//     $documento = Documento::find($request->documento_id);
//     $documento->estado_id = 4;
//     $documento->save();
//     $detalle = DocumentoDetalle::create([
//         'documento_id' => $request->documento_id,
//         'user_id' => $request->user_id,
//         'mensaje' => $request->mensaje
//     ]);
//     return true;
// });
// Route::post('derivar2', function (Request $request) {
//     $documento = Documento::find($request->documento_id);
//     $documento->estado_id = 2;
//     $documento->destinatario_id = $request->destinatario;
//     $documento->save();
//     $detalle = DocumentoDetalle::create([
//         'documento_id' => $request->documento_id,
//         'user_id' => $request->user_id,
//         'mensaje' => $request->mensaje,
//         'destinatario' => $request->destinatario
//     ]);
//     return true;
// });
Route::post('registrar/first/detalle', function (Request $request) {
  
    $detalle = DocumentoDetalle::create([
        'documento_id' => $request->documento_id,
        'user_id' => $request->user_id,
        'mensaje' => $request->mensaje,
        'destinatario_interno' => $request->destinatario_interno,
        'estado_id'=>2,
        'image'=>$request->archivo ? $request->archivo: '[]', 
        'pdf'=>$request->pdf ? $request->pdf: '[]', 
    ]);
});

Route::post('obtener/pdf/documento', function(Request $request){
    $doc= Documento::find($request->id);
    $doc2= json_decode($doc->pdf);
    return $doc2;
});
Route::post('obtener/img/documento', function(Request $request){
    $doc= Documento::find($request->id);
    $doc2= json_decode($doc->archivo);
    return $doc2;
});

Route::post('obtener/pdf/arbol', function(Request $request){
    $doc= DocumentoDetalle::find($request->id);
    $doc2= json_decode($doc->pdf);
    return $doc2;
});
Route::post('obtener/img/arbol', function(Request $request){
    $doc= DocumentoDetalle::find($request->id);
    $doc2= json_decode($doc->image);
    return $doc2;
});


// save Documento ajax
Route::post('documento/save', function (Request $request) {
    return $request;
});

Route::get('images/{id}', function($id){
    return Documento::find($id);
});

//Convocatorias
Route::get('convocatorias', function () {
    return Convocatoria::with('categoria')->orderBy('name', 'asc')->limit(15)->get();
});

Route::get('catconvocatoria/', function(){
    return CatConvocatoria::all();
});

Route::get('convocatorias/filtro/{categoria_id}/{gestion}', function($categoria_id, $gestion){
    return Convocatoria::where('categoria_id', $categoria_id)->where('gestion', $gestion)->orderBy('name', 'asc')->with('categoria')->get();
});

Route::get('5convocatorias', function () {
    return Convocatoria::with('categoria')->orderBy('created_at', 'asc')->limit(5)->get();
});

Route::get('convocatorias/totales', function () {
    return response()->json(['total' => Convocatoria::count()]);
});


//Gacetas
Route::get('gacetas', function () {
    return Gaceta::with('categoria')->orderBy('name', 'desc')->limit(15)->get();
});

Route::get('catgacetas/', function(){
    return CatGaceta::all();
});

Route::post('gacetas/filtro', function(Request $request){
    return Gaceta::where('categoria_id', $request->categoria)->where('gestion', $request->gestion)->orderBy('name', 'asc')->with('categoria')->get();
});

Route::post('gacetas/buscar', function(Request $request){
    $result = Gaceta::where('name', 'like', '%'.$request->criterio.'%')->orderBy('name', 'desc')->with('categoria')->get();
    return $result;
});

Route::get('5gacetas', function () {
    return Gaceta::with('categoria')->orderBy('name', 'desc')->limit(5)->get();
});

Route::get('gacetas/totales', function () {
     return response()->json(['total' => Gaceta::count()]);
});


//Restablecer Password-------
Route::post('credenciales', function(Request $request){
    $user=User::where('phone',$request->phone)->first();
    if ($user!=null) {
        $user->password=Hash::make($request->password);
        $user->save();
    }
    return $user;
});

//Buscar Documento
Route::get('find/documento/{id}', function($id){
    return Documento::where('id', $id)->with('remitente_interno', 'remitente_externo', 'destinatario', 'copias', 'categoria')->first();
});

//Save Rel Deriv Docs
Route::post('save/rel/deriv', function(Request $request){
    RelDerivDoc::create([
        'documento_id' => $request->documento_id,
        'user_id' => $request->user_id
    ]);
});

//Get Documento DetalLe
Route::get('find/documento/detalle/{id}', function($id){
    return DocumentoDetalle::where('documento_id',$id)->get();
});

//Get  DetalLe
Route::get('find/detalle/{id}', function($id){
    return DocumentoDetalle::find($id);
});
//preguntas
Route::get('preguntas', function () {
    return Pregunta::orderBy('created_at', 'desc')->get();
});


//Concejales ---------
Route::get('concejales', function () {
    return Concejale::orderBy('created_at', 'desc')->get();
});
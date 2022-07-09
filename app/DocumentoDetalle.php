<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class DocumentoDetalle extends Model
{
	use SoftDeletes;
    protected $fillable = [
        'documento_id',
        'user_id',
        'mensaje',
        'image', 
        'pdf',
		'destinatario_interno',
        'destinatario_externo'
        ];


    // public function remitente_interno()
    // {
    //     return $this->belongsTo(User::class, 'remitente_id_interno');
    // }
    // public function remitente_externo()
    // {
    //     return $this->belongsTo(Persona::class, 'remitente_id_externo');
    // }
    public function destinatario_interno()
    {
        return $this->belongsTo(User::class, 'destinatario_interno');
    }
    public function destinatario_externo()
    {
        return $this->belongsTo(Persona::class, 'destinatario_externo');
    }
}
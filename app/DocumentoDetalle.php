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
        'destinatario_externo',
        'estado_id'
        ];

    protected $appends=['published', 'fecha'];
    public function getPublishedAttribute(){
        return Carbon::createFromTimeStamp(strtotime($this->attributes['created_at']) )->diffForHumans();
    }
    public function getFechaAttribute(){
        return date('Y-m-d', strtotime($this->attributes['created_at']));
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
    public function destinatario_interno()
    {
        return $this->belongsTo(User::class, 'destinatario_interno');
    }
    public function destinatario_externo()
    {
        return $this->belongsTo(Persona::class, 'destinatario_externo');
    }
}
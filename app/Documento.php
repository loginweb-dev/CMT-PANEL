<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Models\User;
use Carbon\Carbon;

class Documento extends Model
{
	use SoftDeletes;
	protected $fillable = [
	'name',
	'description',
	'estado_id',
	'categoria_id',
	'persona_id',
	'archivo',
	'tipo',
	'user_id',
	'editor_id'
	];
	// protected $appends=['published'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RelDerivDoc extends Model
{
    use SoftDeletes;
	protected $fillable = [
	'documento_id',
    'user_id'
	];
}

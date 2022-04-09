<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Models\User;
use Carbon\Carbon;

class Convocatoria extends Model
{
	use SoftDeletes;
	protected $appends=['published'];
}

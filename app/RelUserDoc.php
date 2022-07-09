<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class RelUserDoc extends Model
{
	use SoftDeletes;

	public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

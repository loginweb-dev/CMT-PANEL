<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Models\User;
use Carbon\Carbon;

class Gaceta extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'file',
        'categoria_id',
        'editor_id',
        'gestion'
        ];
	public function categoria()
    {
        return $this->belongsTo(CatGaceta::class, 'categoria_id');
    }
}

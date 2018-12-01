<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
	protected $table = 'grades';

    public function section() {
    	return $this->belongsTo('App\Models\Section');
    }
}

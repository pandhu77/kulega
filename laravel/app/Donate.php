<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donate extends Model
{
    protected $table = 'lk_donate';

    public function Donatecate()
	{
		return $this->belongsTo('\App\Donatecate','parent','id');
	}
}

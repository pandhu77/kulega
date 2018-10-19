<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donatecate extends Model
{
    protected $table = 'lk_donate_cate';

    public function Donate()
	{
		return $this->hasMany('\App\Donate','id','parent');
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    protected $table = 'friends';

    public function userDetail()
	{
    	return $this->hasOne('App\User','id', 'user_id');
	}

}



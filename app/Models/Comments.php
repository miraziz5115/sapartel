<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    
	protected $table = 'comments';
    
    public function post()
    {
        return $this->belongsTo('App\Posts');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = 'posts';

    protected $fillable = [
    	'user_id',
    	'text',
    ];

    public function comments()
    {
        return $this->hasMany('App\Models\Comments','post_id', 'id');
    }

    public function picture()
	{
    	return $this->hasOne('App\Models\Images','post_id');
	}

	public function userDetail()
	{
    	return $this->hasMany('App\User','id', 'user_id');
	}

    

   


}

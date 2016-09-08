<?php

namespace App;

use Moloquent;

class Like extends  Moloquent
{

    protected $like = 'Like_collection';

    protected static $createRules = array(
		'user_id'	   =>	'required|',
		'post_id'	   =>	'required',
		
		
	);


public function post()
    {
        return $this->belongsTo('App\Post');
    }

	






}

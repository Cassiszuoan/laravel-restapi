<?php

namespace App;

use Moloquent;

class Connection extends  Moloquent
{

    protected $collection = 'Connection_collection';

    protected static $createRules = array(
		'user_from_id'	   =>	'required|',
		'user_to_id'	   =>	'required',
		
		
	);


public function user()
    {
        return $this->belongsTo('App\User');
    }

	






}

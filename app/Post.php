<?php

namespace App;

use Moloquent;

class Connection extends  Moloquent
{

    protected $collection = 'Post_collection';

    protected static $createRules = array(
		'author_id'	   =>	'required|',
		
		
		
	);


public function user()
    {
        return $this->belongsTo('App\User');
    }

	






}

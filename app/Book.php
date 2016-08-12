<?php

namespace App;

use Moloquent;

class Book extends  Moloquent
{

    protected $collection = 'book_collection';

    protected static $createRules = array(
		'name'				=>	'required|unique:name',
		'authorname'	   =>	'required',
		
	);


public function user()
    {
        return $this->belongsTo('App\User');
    }

	






}

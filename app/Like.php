<?php

namespace App;

use Moloquent;

class Like extends  Moloquent
{

    protected $collection = 'Like_collection';

    protected static $createRules = array(
		'user_id'	   =>	'required',
		'post_id'	   =>	'required',
		
		
	);




	






}

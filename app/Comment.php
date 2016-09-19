<?php

namespace App;

use Moloquent;

class Comment extends  Moloquent
{

    protected $collection = 'Comment_collection';

    protected static $createRules = array(
		'user_id'	   =>	'required',
		'post_id'	   =>	'required',
		
		
	);




	






}

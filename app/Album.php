<?php

namespace App;

use Moloquent;

class Album extends  Moloquent
{

    protected $collection = 'Album_collection';

    protected static $createRules = array(
		'album_name'	   =>	'required',
		
		
		
	);




	






}

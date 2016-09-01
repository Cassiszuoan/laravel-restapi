<?php

namespace App;

use Moloquent;

class Baby extends  Moloquent
{

    protected $collection = 'Baby_collection';

    


public function user()
    {
        return $this->belongsTo('App\User');
    }

	






}

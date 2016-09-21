<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;

use Helpers;

use Validator;

use Config;

use Dingo\Api\Exception\ValidationHttpException;




class AlbumController extends BaseController
{

    


	public function htmltoPdf(){

    $snappy = App::make('snapp.pdf');
    $snappy->generateFromHtml('<h1>Bill</h1><p>You owe me money, dude.</p>', 'album/bill-123.pdf');
    $snappy->generate('http://www.github.com', 'album/github.pdf');


 

}


}
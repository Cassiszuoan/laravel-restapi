<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;

use App;

use Helpers;

use Validator;

use Config;

use PDF;

use Dingo\Api\Exception\ValidationHttpException;




class AlbumController extends BaseController
{

    


	public function htmltoPdf(){

    $snappy = App::make('snappy.pdf');
    $snappy->generateFromHtml('<h1>Bill</h1><p>You owe me money, dude.</p>', '/tmp/bill-123.pdf');
    


 

}


}
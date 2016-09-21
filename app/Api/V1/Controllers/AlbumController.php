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

    $snappy = new Pdf();
    $snappy->loadHTML('<h1>Test</h1>');
    return $snappy->inline();
    


 

}


}
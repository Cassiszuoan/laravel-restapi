<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;

use Helpers;

use Validator;

use Config;

use Dingo\Api\Exception\ValidationHttpException;




class BookController extends BaseController
{

    public function index() {
		return Book::all();
	}


	public function store(Request $request){

       
        

       
        
       

        $input = $request->all();



        $validator = Validator::make($input,[
            'name' => 'required|unique:name,authorname',
            'authorname' => 'required',
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $book = new Book;
        $book->name = $input['name'];
        $book->authorname=$input['authorname'];
        $book->save();

        return response()->json($book);








			if ( !$book->save() ) {
				return $this->response->error('could_not_store_book', 500);
			}


	}

}
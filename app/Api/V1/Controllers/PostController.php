<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use Helpers;

use Validator;

use Config;

use Dingo\Api\Exception\ValidationHttpException;




class PostController extends BaseController
{

    public function index() {
		return Post::all();
	}


	public function store(Request $request){
   

        $input = $request->all();



        $validator = Validator::make($input,[
            'token' => 'required',
            'content'=>'required',
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }


        $post = new Post;
        $author = User::where('accesstoken','=',$input['token'])->first();
        $post->author_name=$author->name;
        $post->author_id=$author->_id;
        $post->content=$input['content'];
        $post->save();

        
        return response()->json($post);



			if ( !$post->save() ) {
				return $this->response->error('could_not_store_post', 500);
			}


	}

}
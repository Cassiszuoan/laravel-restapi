<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Like;

use App\User;

use App\Post;

use Helpers;

use Validator;

use Config;

use Dingo\Api\Exception\ValidationHttpException;






class LikeController extends BaseController
{

    public function index() {
		return Like::all();
	}



    public function press_like(Request $request){
         
         $input = $request->all();


        $validator = Validator::make($input,[
            'token'       =>   'required', 
            'post_id'     =>   'required',
        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }




        $accesstoken = $input['token'];
        $post_id = $input['post_id'];

        $user = User::where('accesstoken','=',$accesstoken)->first();

        $user_id = $user->_id;
        $user_name= $user->name;


        $check_like = Like::where('user_id','=',$user_id)->where('post_id','=',$post_id)->first();


        if(empty($check_like)){



        $like = new Like;
        $like->user_id = $user_id;
        $like->post_id = $post_id;
        $like->user_name = $user_name;
        $like->save();


        $liked_post = Post::where('_id','=',$post_id)->first();
        $count = Like::where('user_id','=',$user_id)->where('post_id','=',$post_id)->count();
        $liked_post->likes = $count;
        $liked_post->save();



        }


        else {


        return $this->response->error('Like has already pressed', 500);


        }

        


        


           
 
       return response()->json($like);

    }




    


    public function cancel_like(Request $request){

         $input = $request->all();
        
         $validator = Validator::make($input,[
            'token'       =>   'required',
            'post_id'       =>   'required',
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        
        $accesstoken = $input['token'];

        $user = User::where('accesstoken','=',$accesstoken)->first();

        $user_id = $user->_id;

        $post_id = $input['post_id'];
    
        $like = Like::where('user_id','=',$user_id)->where('post_id','=',$input['post_id'])->first();


        if(!$like){
    
         return $this->response->error('Like not Found', 500);

        }
        
        $like->delete();


        


        if(Like::where('user_id','=',$user_id)){
            $count = Like::where('user_id','=',$user_id)->count();
        }
        else{

            $count = 0 ;
        }


        $liked_post = Post::where('_id','=',$post_id)->first();
        $liked_post->likes=$count;
        $liked_post->save();
        
        



        return response()->json(['message' => 'Like has been deleted', 'status code' => '200']);



    }




}
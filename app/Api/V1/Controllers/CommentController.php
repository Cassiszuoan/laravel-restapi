<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Comment;

use App\User;

use App\Post;

use Helpers;

use Validator;

use Config;

use Dingo\Api\Exception\ValidationHttpException;






class CommentController extends BaseController
{

    public function index() {
		return Comment::all();
	}



    public function comment(Request $request){
         
         $input = $request->all();


        $validator = Validator::make($input,[
            'token'       =>   'required', 
            'post_id'     =>   'required',
            'content'     =>   'required',
        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }




        $accesstoken = $input['token'];
        $post_id = $input['post_id'];
        $content = $input['content'];

        $user = User::where('accesstoken','=',$accesstoken)->first();

        $user_id = $user->_id;
        $user_name= $user->name;
        $avatar=$user->avatar;


        


    

        $Comment = new Comment;
        $Comment->user_id = $user_id;
        $Comment->post_id = $post_id;
        $Comment->user_name = $user_name;
        $Comment->user_avatar=$avatar;
        $Comment->content=$content;
        $Comment->save();


        $Commented_post = Post::where('_id','=',$post_id)->first();
             
        $Commented_post->comments()->associate($Comment);

        $Commented_post->save();


        

           
 
        return response()->json($Comment);

    }




    


    public function delete_comment(Request $request){

         $input = $request->all();
        
         $validator = Validator::make($input,[
            'token'       =>   'required',
            'comment_id'       =>   'required',
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        
        $accesstoken = $input['token'];

        $user = User::where('accesstoken','=',$accesstoken)->first();

        $user_id = $user->_id;

        $comment_id = $input['comment_id'];
    
        $Comment = Comment::where('user_id','=',$user_id)->where('_id','=',$comment_id)->first();


        if(!$Comment){
    
         return $this->response->error('Comment not Found', 500);

        }
        
        
        $Commented_post = Post::where('_id','=',$post_id)->first();

        $Commented_post->Comments()->dissociate($Comment);

        $Comment->delete();     
        
        $Commentd_post->save();


        return response()->json(['message' => 'Comment has been deleted', 'status code' => '200']);



    }




}
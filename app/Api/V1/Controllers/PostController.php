<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use App\User;

use App\Connection;

use Helpers;

use Validator;

use Config;

use Dingo\Api\Exception\ValidationHttpException;

use Intervention\Image\Facades\Image as Image;




class PostController extends BaseController
{

    public function index() {
		return Post::all();
	}


    public  function search(Request $request){

          $input = $request -> all();
          $validator = Validator::make($input,[
            'token' => 'required',
            
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $author = User::where('accesstoken','=',$input['token'])->first();
        $author_id = $author->_id;
        $posts =  Post::where('author_id','=',$author_id)->get();



        return response()->json($posts);


    }


    public function image_upload(Request $request){

      $input = $request->all();

      $validator = Validator::make($input,[
            'token'       =>   'required',
            'post_id'     =>   'required',

        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }



$user = User::where('accesstoken','=',$input['token'])->first();
$user_id = $user->_id;
$post_id = $input['post_id'];
$post = Post::where('_id','=',$post_id)->first();


$filename = time() . '.' . basename($_FILES['pic']['name']);

$path = "uploads/{$user_id}/posts/";



if (!file_exists($path)) {
    mkdir($path, 0777, true);
    $uploaddir = $path;
}
else{
  $uploaddir = $path;
}
// PS: custom filed name : pic




$uploadfile = $uploaddir . $post_id;


if(file_exists($uploadfile)){

  unlink($uploadfile);

  if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadfile)) {
   $imgurl = "http://140.136.155.143/". $uploadfile;
   $post->imgurl =  "http://140.136.155.143/". $uploadfile;
   $post->small_imgurl = "http://140.136.155.143/". $uploadfile . '_300*300';
   $post->save();


   $img = Image::make($imgurl);
   $img->resize(300, 300);
   $img->save($uploadfile . '_300*300');
   $array = array ("code" => "1", "message" => "successfully","url"=>"140.136.155.143/". $uploadfile);  
} else {
   $array = array ("code" => "0", "message" => "Possible file upload attack!".$_FILES['pic']['name']); 
}


}


else{

if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadfile)) {
   $imgurl = "http://140.136.155.143/". $uploadfile;
   $post->imgurl =  "http://140.136.155.143/". $uploadfile;
   $post->small_imgurl = "http://140.136.155.143/". $uploadfile . '_300*300';
   $post->save();

   $img = Image::make($imgurl);
   $img->resize(300, 300);
   $img->save($uploadfile . '_300*300');

   $array = array ("code" => "1", "message" => "successfully","url"=>"140.136.155.143/". $uploadfile);  
} else {
   $array = array ("code" => "0", "message" => "Possible file upload attack!".$_FILES['pic']['name']); 
}


}

echo json_encode ( $array );



    }



    public function news_feed(Request $request){


     $input = $request->all();



    $validator = Validator::make($input,[
            'token' => 'required',
            
     ]);

 
    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }


    $user = User::where('accesstoken','=',$input['token'])->first();


    
    $user_from_id = $user->_id;

    $connection = Connection::where('user_from_id','=',$user_from_id)->get();


    $followinglist = array();


    foreach($connection as $i){

    $followinguser = $i->user_to_id;

    array_push($followinglist,$followinguser);
        
    }

   
  

   // 這邊將追蹤中的post加入陣列
   $news = array();

   foreach($followinglist as $author_id){

    

   if(!empty($post = Post::where('author_id','=',$author_id)->get())){
   
   array_push($news,$post);

   }

   else{
  
   

   }


}


// 這邊將自己的post 加入陣列

if(!empty($self_post = Post::where('author_id','=',$user_from_id)->get())){

  array_push($news,$self_post);
}

else{


}


// 讓post照時間排序

    

usort($news, function($a1, $a2) {
   $v1 = strtotime($a1['created_at']);
   $v2 = strtotime($a2['created_at']);
   return $v2 - $v1; // $v2 - $v1 to reverse direction
});


return response()->json($news);



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
        $post->author_imgurl=$author->avatar;
        $post->content=$input['content'];
        $post->save();

        
        return response()->json($post);



			if ( !$post->save() ) {
				return $this->response->error('could_not_store_post', 500);
			}


	}

}
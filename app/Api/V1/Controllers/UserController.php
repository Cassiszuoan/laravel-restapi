<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use JWTAuth;
use Validator;
use Config;
use App\User;
use Illuminate\Mail\Message;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Exception\ValidationHttpException;
use App\Api\V1\Transformers\UserTransformer;
use Intervention\Image\Facades\Image as Image;

class UserController extends BaseController
{
    use Helpers;

    public function index() {


      
      return $this->response->collection(User::all(), new UserTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());

    }



public function uploadImage(Request $request){

$input = $request->all();

$validator = Validator::make($input,[
            'token'       =>   'required',

        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }


$user = User::where('accesstoken','=',$input['token'])->first();
$user_id = $user->_id;



$filename = time() . '.' . basename($_FILES['pic']['name']);

$path = "uploads/{$user_id}/avatar/";



if (!file_exists($path)) {
    mkdir($path, 0777, true);
    $uploaddir = $path;
}
else{
  $uploaddir = $path;
}
// PS: custom filed name : pic




$uploadfile = $uploaddir . "avatar";


if(file_exists($uploadfile)){

  unlink($uploadfile);

  if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadfile)) {

   $user->avatar =  "http://140.136.155.143/". $uploadfile;
   $user->save();
   $array = array ("code" => "1", "message" => "successfully","url"=>"140.136.155.143/". $uploadfile);  
} else {
   $array = array ("code" => "0", "message" => "Possible file upload attack!".$_FILES['pic']['name']); 
}


}


else{

if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadfile)) {
   $user->avatar =  "http://140.136.155.143/". $uploadfile;
   $user->save();
   $array = array ("code" => "1", "message" => "successfully","url"=>"140.136.155.143/". $uploadfile);  
} else {
   $array = array ("code" => "0", "message" => "Possible file upload attack!".$_FILES['pic']['name']); 
}


}

echo json_encode ( $array );



}



    



    public function get($name) {


       $user = User::where('name','=',$name)->get();
       
       return $this->response->collection($user, new UserTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());

    }




    public function getUserByToken($token) {

    	$user = User::where('accesstoken','=',$token)->get();
    	return $this->response->collection($user, new UserTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());

    }



    public function getUserById($id){

      $user = User::where('_id','=',$id)->first();

      return response()->json($user);


    }


    public function search(Request $request){


      $input = $request->all();


        $validator = Validator::make($input,[
            'email'       =>   'required',

        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }


      $email = $input['email'];

      $user = User::where('email','like',"%{$email}%")->get();
      return $this->response->collection($user, new UserTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());
    }




    public function update(Request $request){

      $input = $request->all();



      $validator = Validator::make($input,[
            'token'       =>   'required',    
        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }


        $user = User::where('accesstoken','=',$input['token'])->first();

        if(!empty($input['name'])){

          $user->name= $input['name'];
          $user->save();

        }


        if(!empty($input['about'])){

          $user->userbio= $input['about'];
          $user->save();

        }



        if(!empty($input['website'])){

          $user->userweb= $input['website'];
          $user->save();

        }





    }










}

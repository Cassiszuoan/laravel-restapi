<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use App\Baby;

use App\Connection;

use Helpers;

use Validator;

use Config;

use Dingo\Api\Exception\ValidationHttpException;

use Intervention\Image\Facades\Image as Image;




class BabyController extends BaseController
{

    public function index() {
		return Baby::all();
	}


    public  function search(Request $request){

          $input = $request -> all();
          $validator = Validator::make($input,[
            'token' => 'required',
            
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $parent = User::where('accesstoken','=',$input['token'])->first();
        $parent_id = $parent->_id;
        $Babys =  Baby::where('parent_id','=',$parent_id)->orderBy('created_at','DESC')->get();



        return response()->json($Babys);


    }



    public  function search_by_id(Request $request){

          $input = $request -> all();
          $validator = Validator::make($input,[
            'id' => 'required',
            
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $parent = User::where('_id','=',$input['id'])->first();
        $Babys =  Baby::where('parent_id','=',$input['id'])->orderBy('created_at','DESC')->get();



        return response()->json($Babys);


    }



    public function image_upload(Request $request){

      $input = $request->all();

      $validator = Validator::make($input,[
            'token'       =>   'required',
            'Baby_id'     =>   'required',

        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }



$user = User::where('accesstoken','=',$input['token'])->first();
$user_id = $user->_id;
$Baby_id = $input['Baby_id'];
$Baby = Baby::where('_id','=',$Baby_id)->first();


$filename = time() . '.' . basename($_FILES['pic']['name']);

$path = "uploads/{$user_id}/Babys/";



if (!file_exists($path)) {
    mkdir($path, 0777, true);
    $uploaddir = $path;
}
else{
  $uploaddir = $path;
}
// PS: custom filed name : pic




$uploadfile = $uploaddir . $Baby_id;


if(file_exists($uploadfile)){

  unlink($uploadfile);

  if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadfile)) {
   $imgurl = "http://140.136.155.143/". $uploadfile;
   $Baby->imgurl =  "http://140.136.155.143/". $uploadfile;
   $Baby->small_imgurl = "http://140.136.155.143/". $uploadfile . '_300*300';
   $Baby->save();


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
   $Baby->imgurl =  "http://140.136.155.143/". $uploadfile;
   $Baby->small_imgurl = "http://140.136.155.143/". $uploadfile . '_300*300';
   $Baby->save();

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



    




	public function store(Request $request){
   

        $input = $request->all();



        $validator = Validator::make($input,[
            'token' => 'required',
            'name'=>'required',
            'birth'=>'required',
            'blood'=>'required',
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }


        $Baby = new Baby;
        $parent = User::where('accesstoken','=',$input['token'])->first();
        $Baby->baby_name=$input['name'];
        $Baby->baby_birth=$input['birth'];
        $Baby->baby_blood=$input['blood'];
        $Baby->parent_name=$parent->name;
        $Baby->parent_id=$parent->_id;
        
        $Baby->save();

        
        return response()->json($Baby);



			if ( !$Baby->save() ) {
				return $this->response->error('could_not_store_Baby', 500);
			}


	}



  public function delete(Request $request){



         $input = $request->all();
        
         $validator = Validator::make($input,[
            'object_id'       =>   'required',
            
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }


        $Baby = Baby::where('_id','=',$input['object_id'])->first();


        if(!$Baby){
    
         return $this->response->error('Baby not Found', 500);

        }
        
        $Baby->delete();


        return response()->json(['message' => 'Baby has been deleted', 'status code' => '200']);

        
        



  }

}
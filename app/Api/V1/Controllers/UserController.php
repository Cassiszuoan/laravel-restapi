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

class UserController extends BaseController
{
    use Helpers;

    public function index() {


      
      return $this->response->collection(User::all(), new UserTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());

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

      $user = User::find($id)->get();

      return $this->response->collection($user, new UserTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());
      

    }


    public function search(Request $request){


      $input = $request->all();


        $validator = Validator::make($input,[
            'email'       =>   'required',    
        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

      $user = User::where('email','=',$input['email'])->get();
      return $this->response->collection($user, new UserTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());
    }










}

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

    	$user = User::where('accesstoken','like',$token)->get();
    	return $this->response->collection($user, new UserTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());

    }










}

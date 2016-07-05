<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Connection;

use App\User;

use Helpers;

use Validator;

use Config;

use Dingo\Api\Exception\ValidationHttpException;




class ConnectionController extends BaseController
{

    public function index() {
		return Connection::all();
	}



    public function search(Request $request){
         
         $input = $request->all();


        $validator = Validator::make($input,[
            'token'       =>   'required',    
        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }




        $accesstoken = $input['token'];

        $user = User::where('accesstoken','like',$accesstoken)->first();

        $user_from_id = $user->_id;

        $connection = Connection::where('user_from_id','=',$user_from_id);


        return response()->json($connection)->addMeta('status Code', app('Illuminate\Http\Response')->status());


    }


	public function connect(Request $request){

       

        $input = $request->all();


        $validator = Validator::make($input,[
            'token'       =>   'required',
            'user_to_id'       =>   'required',
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }





        $accesstoken = $input['token'];

        $user = User::where('accesstoken','like',$accesstoken)->first();

        $user_from_id = $user->_id;
        

        

        

        $connection = new Connection;
        $connection->user_from_id = $user_from_id;
        $connection->user_to_id=$input['user_to_id'];
        $connection->save();
        $user->connections()->associate($connection);
        $user->connections()->save($connection);
        $user->save();

   


        return response()->json($connection)->addMeta('status Code', app('Illuminate\Http\Response')->status());








			if ( !$connection->save() ) {
				return $this->response->error('could_not_store_connection', 500);
			}


	}

}
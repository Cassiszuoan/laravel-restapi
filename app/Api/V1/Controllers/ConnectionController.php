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



    public function search_following(Request $request){
         
         $input = $request->all();


        $validator = Validator::make($input,[
            'token'       =>   'required',    
        ]);



    if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }




        $accesstoken = $input['token'];

        $user = User::where('accesstoken','=',$accesstoken)->first();

        $user_from_id = $user->_id;

        $connection = Connection::where('user_from_id','=',$user_from_id)->get();


        $totalconnection = Connection::where('user_from_id','=',$user_from_id)->count();

        $user->following_count = $totalconnection;

        $user->save();


        return response()->json($connection);


    }




    public function search_followed(Request $request){


        $input = $request->all();
        
         $validator = Validator::make($input,[
            'token'       =>   'required',

        ]);



         if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }



        $accesstoken = $input['token'];

        $user = User::where('accesstoken','=',$accesstoken)->first();


        $user_id = $user->_id;



        $connection = Connection::where('user_to_id','=',$user_id)->get();

        


        $totalconnection = Connection::where('user_to_id','=',$user_id)->count();

        $user->followed_count = $totalconnection;

        $user->save();


        return response()->json($connection);




    }


    public function delete(Request $request){

         $input = $request->all();
        
         $validator = Validator::make($input,[
            'token'       =>   'required',
            'user_to_id'       =>   'required',
        ]);


        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        
        $accesstoken = $input['token'];

        $user = User::where('accesstoken','=',$accesstoken)->first();

        $user_from_id = $user->_id;


    
        $connection = Connection::where('user_from_id','=',$user_from_id)->where('user_to_id','=',$input['user_to_id']);

        $connection->delete();



        $totalconnection = Connection::where('user_from_id','=',$user_from_id)->count();

        $user->following_count = $totalconnection;

        $user->save();


        if ( !$connection->delete() ) {
                return $this->response->error('could_not_delete_connection', 500);
            }






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

        $user = User::where('accesstoken','=',$accesstoken)->first();

        $user_from_id = $user->_id;


        

        

        
        
        $connection = new Connection;
        $connection->user_from_id = $user_from_id;
        $connection->user_to_id=$input['user_to_id'];
        $connection->following_user_img= 'testing url';

        

        $followinguser = User::where('_id','=',$input['user_to_id'])->first();

        if(!$followinguser){

            return $this->response->error('user_to_id not Found', 500);

        }
        $connection->following_user_name = $followinguser->name;
        $connection->save();
        

        $totalconnection = Connection::where('user_from_id','=',$user_from_id)->count();

        $user->following_count = $totalconnection;

        $user->save();

        // $user->connections()->associate($connection);
        // $user->connections()->save($connection);
        // $user->save();

   


        return response()->json($connection);








			if ( !$connection->save() ) {
				return $this->response->error('could_not_store_connection', 500);
			}


	}

}
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

use App\Api\V1\Transformers\FollowingTransformer;

use App\Api\V1\Transformers\FollowedTransformer;




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
     

    foreach($connection as $i){
       
        $i->following_user_img= 'testing url';

        $user_to_id = $i->user_to_id;

        $followinguser = User::where('_id','=',$user_to_id)->first();

        $i->following_user_name = $followinguser->name; 

        $i->save();
         

     }

        

        




        $totalconnection = Connection::where('user_from_id','=',$user_from_id)->count();

        $user->following_count = $totalconnection;

        $followerconnection = Connection::where('user_to_id','=',$user_from_id)->count();

        $user->follower_count =  $followerconnection;

        $user->save();


        
 


       return $this->response->collection($connection, new FollowingTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());

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


        $user_from_id = $user->_id;

        $connection = Connection::where('user_to_id','=',$user_from_id)->get();





        foreach($connection as $i){
       
        $i->following_user_img= 'testing url';

        $user_from_id = $i->user_from_id;

        $followeruser = User::where('_id','=',$user_from_id)->first();

        $i->follower_user_name = $followeruser->name; 

        $i->save();
         

     }

        


        $totalconnection = Connection::where('user_from_id','=',$user_from_id)->count();

        $user->following_count = $totalconnection;

        $followerconnection = Connection::where('user_to_id','=',$user_from_id)->count();

        $user->follower_count =  $followerconnection;

        $user->save();


        return $this->response->collection($connection, new FollowedTransformer)->addMeta('status Code', app('Illuminate\Http\Response')->status());;




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


    
        $connection = Connection::where('user_from_id','=',$user_from_id)->where('user_to_id','=',$input['user_to_id'])->first();


        if(!$connection){
    
         return $this->response->error('connection not Found', 500);

        }
        
        $connection->delete();


        $deleteuser = User::where('_id','=',$input['user_to_id'])->first();


        if(Connection::where('user_to_id','=',$input['user_to_id'])){
            $count = Connection::where('user_to_id','=',$input['user_to_id'])->count();
        }
        else{

            $count = 0 ;
        }

        $deleteuser->follower_count = $count;
        $deleteuser->save();
        



        $totalconnection = Connection::where('user_from_id','=',$user_from_id)->count();

        $user->following_count = $totalconnection;

        $followerconnection = Connection::where('user_to_id','=',$user_from_id)->count();

        $user->follower_count =  $followerconnection;

        $user->save();


        return response()->json(['message' => 'Connection has been deleted', 'status code' => '200']);


        






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
        // $connection->following_user_img= 'testing url';

        

        $followinguser = User::where('_id','=',$input['user_to_id'])->first();

        



        if(!$followinguser){

            return $this->response->error('user_to_id not Found', 500);

        }
        // $connection->following_user_name = $followinguser->name;
        $connection->save();
        

        $followingconnection = Connection::where('user_from_id','=',$user_from_id)->count();
        $followerconnection = Connection::where('user_to_id','=',$user_from_id)->count();

        $user->following_count = $followingconnection;
        $user->follower_count =  $followerconnection;

        $user->save();

        // $user->connections()->associate($connection);
        // $user->connections()->save($connection);
        // $user->save();




        if(Connection::where('user_to_id','=',$input['user_to_id'])){
            $count = Connection::where('user_to_id','=',$input['user_to_id'])->count();
        }
        else{

            $count = 0 ;
        }

        $followinguser->follower_count = $count;
        $followinguser->save();

   


        return response()->json($connection);








			if ( !$connection->save() ) {
				return $this->response->error('could_not_store_connection', 500);
			}


	}

}
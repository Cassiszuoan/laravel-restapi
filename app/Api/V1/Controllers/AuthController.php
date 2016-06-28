<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use Validator;
use Config;
use App\User;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Exception\ValidationHttpException;

class AuthController extends Controller
{
    use Helpers;



    
    public function login(Request $request)
    {

        $this->getValidatorInstance()->getPresenceVerifier()->setConnection('mongodb');
        $credentials = $request->only(['email', 'password']);
        
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            return $this->response->error('could_not_create_token', 500);
        }
        $user = User::where('email','=',$credentials['email'])->first();
        $user->accesstoken=compact('token');
        $user->save();
        return response()->json(compact('token'));
    }

    public function signup(Request $request)
    {
        $this->getValidatorInstance()->getPresenceVerifier()->setConnection('mongodb');
        $signupFields = Config::get('boilerplate.signup_fields');
        $hasToReleaseToken = Config::get('boilerplate.signup_token_release');

        $userData = $request->only($signupFields);

       

        $validator = Validator::make($userData, Config::get('boilerplate.signup_fields_rules'));

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        
        $user = new User;

        // $book = Book::Where('authorname', 'Mike')->get();
        
    //     $book = Book::all();
        

    //     foreach($book as $i){
    //   $user->books()->associate($i);
    //   $user->books()->save($i);
       

    // }
// 這邊是讓一個user擁有多本書籍的範例


        $user->name = $userData['name'];
        $user->email=$userData['email'];
        $user->password=$userData['password'];
        $user->follower_count=0;
        $user->followed_count=0;
        $user->fb_id="";
        $user->fb_accesstoken="";
        $user->save();
        
        
        

        if(!$user->id) {
            return $this->response->error('could_not_create_user', 500);
        }

        if($hasToReleaseToken) {
            return $this->login($request);
        }

        return $this->response->created();
    }



    public function recovery(Request $request)
    {
        $this->getValidatorInstance()->getPresenceVerifier()->setConnection('mongodb');
        $validator = Validator::make($request->only('email'), [
            'email' => 'required'
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject(Config::get('boilerplate.recovery_email_subject'));
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->response->noContent();
            case Password::INVALID_USER:
                return $this->response->errorNotFound();
        }
    }

    public function reset(Request $request)
    {
        $this->getValidatorInstance()->getPresenceVerifier()->setConnection('mongodb');
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $validator = Validator::make($credentials, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }
        
        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                if(Config::get('boilerplate.reset_token_release')) {
                    return $this->login($request);
                }
                return $this->response->noContent();

            default:
                return $this->response->error('could_not_reset_password', 500);
        }
    }
}
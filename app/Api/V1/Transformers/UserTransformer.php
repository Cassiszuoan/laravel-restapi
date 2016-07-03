<?php  


namespace App\Api\V1\Transformers;


use League\Fractal\TransformerAbstract;

use App\User;


class UserTransformer extends TransformerAbstract




{



    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'            => $user->_id,
            'name'          => $user->name,
            'email'         => $user->email,
            'bio'           => $user->userbio,
            'web'           => $user->userweb,
            'follower_count'=> $user->follower_count,
            'followed_count'=> $user->followed_count,
            'posts_count'=> $user->posts_count,
            'social_ids' => [
                 
                'facebook_id' => $user->fb_id,
                

            ],
            'created_time' =>$user->created_at,
            'updated_time' =>$user->updated_at,
            'connections'=>$user->connections,

            'access_token' => [

            'api_accesstoken'=>$user->accesstoken,
            'facebook_accesstoken'=>$user->fb_accesstoken,

            ]


            
                     
        
        ];
    }





}
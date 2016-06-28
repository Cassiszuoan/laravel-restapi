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
            // 'books'         => $user->books,
            'social_ids' => [
                 
                'facebook_id' => $user->fb_id,
                'facebook_accesstoken'=>$user->fb_accesstoken,

            ],
            
                     
        
        ];
    }





}
<?php  


namespace App\Api\V1\Transformers;


use League\Fractal\TransformerAbstract;

use App\Connection;


class FollowingTransformer extends TransformerAbstract




{



    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Connection $connection)
    {
        return [


            'user_id'       => $connection->user_to_id,
            'username'      => $connection->following_user_name,
            'profile_picture'=> $connection->avatar,

            
       
        
        ];
    }





}
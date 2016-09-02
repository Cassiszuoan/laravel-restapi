<?php  


namespace App\Api\V1\Transformers;


use League\Fractal\TransformerAbstract;

use App\Connection;


class FollowedTransformer extends TransformerAbstract




{



    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Connection $connection)
    {
        return [


            'user_id'       => $connection->user_from_id,
            'username'      => $connection->follower_user_name,
            'profile_picture'=> $connection->avatar,
            
       
        
        ];
    }





}
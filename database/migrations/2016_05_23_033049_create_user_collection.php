<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_collection', function ($collection) {
            $collection->string('name');
            $collection->string('email')->unique();
            $collection->string('password');
            $collection->string('accesstoken')->unique();
            $collection->int('follower_count')->default(0);
            $collection->int('followed_count')->default(0);
            $collection->string('fb_id')->unique();
            $collection->string('fb_accestoken');
            $collection->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_collection');
    }
}

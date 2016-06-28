<?php

namespace App;



use Moloquent;



use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Moloquent implements AuthenticatableContract,CanResetPasswordContract
{

    use Authenticatable,CanResetPassword;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $collection = 'user_collection';

    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * This mutator automatically hashes the password.
     *
     * @var string
     */


    public function books()
    {
        return $this->embedsMany('App\Book');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }
}



<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Eloquent implements AuthenticatableContract, AuthorizableContract
{
    use Notifiable, Authenticatable, Authorizable;

    protected $primaryKey = 'api_token';

    public $incrementing = false;

    protected $collection = 'users_collection';

    protected $connection = 'mongodb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['api_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    public function generateUniqueApiToken()
    {
        while (self::find($api_token = str_random(60))) {
            $api_token = str_random(60);
        }
        return $api_token;
    }
}

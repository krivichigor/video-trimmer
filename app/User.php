<?php

namespace App;

use Illuminate\Http\Request;
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


    /*
     * Relations
    */
    
    public function video_processes()
    {
        return $this->hasMany('App\VideoProcess');
    }

    /*
     * Methods
    */

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->api_token = $model->generateUniqueApiToken();
        });
    }

    public function generateUniqueApiToken()
    {
        while (self::where('api_token', $api_token = str_random(60))->get()->first()) {
            $api_token = str_random(60);
        }
        return $api_token;
    }

    public function createVideoProcess(array $data)
    {
        $videoProcess = $this->video_processes()->create([
            'trim_from' => $data['trim_from'],
            'trim_to' =>$data['trim_to']
        ]);
        $videoProcess->saveOriginalVideo($data['video'])
                     ->setDefaultStatus();
        return $videoProcess;
    }
}

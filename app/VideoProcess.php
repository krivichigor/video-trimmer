<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoProcess extends Model
{

    protected $collection = 'video_processes_collection';

    protected $connection = 'mongodb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['trim_from', 'trim_to'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function original_video()
    {
        return $this->embedsOne('Video');
    }

    public function result_video()
    {
        return $this->embedsOne('Video');
    }
}

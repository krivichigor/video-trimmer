<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

	protected $collection = 'video_processes_collection';

    protected $connection = 'mongodb';
    
    public function video_process()
    {
        return $this->belongsTo('VideoProcess');
    }
}

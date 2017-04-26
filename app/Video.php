<?php

namespace App;

use App\Classes\UploadedVideo;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Video extends Eloquent
{
	protected $collection = 'video_collection';

    protected $connection = 'mongodb';

    protected $fillable = ['url', 'duration'];

    protected $hidden = ['created_at', 'updated_at', '_id', ];
    
    /*
     * Relations
    */
    
    public function video_process()
    {
        return $this->hasOne('App\VideoProcess');
    }

    /*
     * Methods
    */

    public function createFromFile(UploadedFile $file)
    {
    	$video = new UploadedVideo($file);
    	$folder_path = 'videos/original'; ///' . $this->video_process->user->id . ' - path with user_id folder

		$this->url 		= $video->moveFile($folder_path);
		$this->duration = $video->getDuration();
        return $this;
    }

    


}

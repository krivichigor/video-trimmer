<?php

namespace App;

use App\Video;
use App\Jobs\TrimVideo;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VideoProcess extends Eloquent
{

    const STATUS_DONE       = 'done';
    const STATUS_FAILED     = 'failed';
    const STATUS_DEFAULT    = 'scheduled';
    const STATUS_PROCESSING = 'processing';

    protected $collection = 'video_processes_collection';

    protected $connection = 'mongodb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['trim_from', 'trim_to', 'status',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'user_id', 'original_video_id', 'result_video_id'];


    protected $dates = ['trim_finished_at'];


    /*
     * Relations
    */

    public function original_video()
    {
        return $this->belongsTo('App\Video');
    }

    public function result_video()
    {
        return $this->belongsTo('App\Video');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*
     * Scopes
    */

    public function scopeWithVideos($query)
    {
        return $query->with(['result_video', 'original_video']);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    /*
     * Methods
    */


    public function saveOriginalVideo(UploadedFile $file)
    {
        $video = new Video;
        $video->createFromFile($file)->save();

        $this->original_video()->associate($video);
        return $this;
        
    }

    /*
     * Working with statuses
    */

    public function setDefaultStatus()
    {
        $this->setStatus(self::STATUS_DEFAULT);
        dispatch(new TrimVideo($this));
    }

    public function setStatusProcessing(){
        $this->setStatus(self::STATUS_PROCESSING);
    }

    public function setStatusFailed(){
        $this->setStatus(self::STATUS_FAILED);
    }

    public function setStatusDone(){
        $this->trim_finished_at = \Carbon\Carbon::now();
        $this->setStatus(self::STATUS_DONE);
    }

    protected function setStatus($status){
        $this->status = $status;
        $this->save();
    }

    public function canBeRestarted(){
        return ($this->status == self::STATUS_FAILED);
    }

    


    

}

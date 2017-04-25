<?php

namespace App;

use App\Video;
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
    protected $fillable = ['trim_from', 'trim_to', 'status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    /*
     * Relations
    */

    public function original_video()
    {
        return $this->hasOne('App\Video');
    }

    public function result_video()
    {
        return $this->hasOne('App\Video');
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

    /*
     * Methods
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            $model->setDefaultStatus();
        });
    }

    protected function setDefaultStatus()
    {
        $this->attributes['status'] = self::STATUS_DEFAULT;
        return true;
    }

    public function setStatusProcessing(){
        $this->setStatus(self::STATUS_PROCESSING);
    }

    public function setStatusFailed(){
        $this->setStatus(self::STATUS_FAILED);
    }

    public function setStatusDone(){
        $this->setStatus(self::STATUS_DONE);
    }

    protected function setStatus($status){
        $this->status = $status;
        $this->save();
    }

    public function saveOriginalVideo(UploadedFile $file)
    {
        $video = new Video;
        $video->video_process()->associate($this);
        $video->createFromRequest($file);
        $video->save();
    }


    

}

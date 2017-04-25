<?php

namespace App\Jobs;

use App\Video;
use App\VideoProcess;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TrimVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video_process;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(VideoProcess $video_process)
    {
        $this->video_process = $video_process;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->video_process->setStatusProcessing();
        $this->video_process->result_video = $this->trim();
        $this->video_process->setStatusDone();
    }

    /* *
     * Cause we do not use FFMPEG for real trimming the video,
     * setting delay 20-120 s
     *
     * @return Video
     */

    protected function trim()
    {
        $min = ENV('TRIM_MIN_SLEEP_TIME', 20);
        $max = ENV('TRIM_MAX_SLEEP_TIME', 120);
        sleep(rand($min, $max));
        return Video::create($this->video_process->original_video->toArray());
    }


}

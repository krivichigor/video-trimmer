<?php

namespace Tests\Unit;

use App\VideoProcess;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoProcessTest extends ApiTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function tests_save_original_video_method()
    {
    	$process = new VideoProcess;

        $file = $this->getTestingFile('1.flv');
    	$result = $process->saveOriginalVideo($file);

        $this->assertTrue($result instanceof VideoProcess);
        $this->assertTrue($result->original_video instanceof \App\Video);
        
    }
}

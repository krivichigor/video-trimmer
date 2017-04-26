<?php

namespace Tests\Unit;

use App\Video;
use Tests\ApiTestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTest extends ApiTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function tests_create_from_file_method()
    {
    	$video = new Video;

        $file = $this->getTestingFile('2.flv');
    	$video->createFromFile($file);
        
        $this->assertTrue(is_string($video->url));
        $this->assertTrue(is_float($video->duration));

        $url_without_domain = str_replace(url('/').'/', '', $video->url);
        
        Storage::disk('public')->assertExists($url_without_domain);
    }
}

<?php

namespace Tests\Unit;

use App\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserModelTest extends ApiTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function tests_generating_api_token_method()
    {
    	$user = new User;
    	$token = $user->generateUniqueApiToken();

        $this->assertTrue(is_string($token));
        $this->assertTrue(strlen($token) == 60);

        $this->assertTrue(!User::where('api_token', $api_token = str_random(60))->get()->first());
    }

    public function tests_create_video_process_method()
    {
    	$user = new User;
    	$data = [
    		'trim_from' => 1,
    		'trim_to'   => 2,
    		'video'	    => $this->getTestingFile('1.flv'),
    	];
    	$result = $user->createVideoProcess($data);

        $this->assertTrue($result instanceof \App\VideoProcess);
    
    }
}

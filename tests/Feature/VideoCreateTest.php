<?php

namespace Tests\Feature;

use App\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoCreateTest extends ApiTestCase
{
	const URL    = 'api/v1/videos';
	const METHOD = 'POST';
    
    public function tests_creating_video_without_auth_expected_401()
    {
        $this->json(self::METHOD, self::URL)
             ->assertStatus(401)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }

    public function tests_creating_video_with__wrond_auth_401()
    {
        $this->json(self::METHOD, self::URL, [], ['Authorization' => 'Test'])
             ->assertStatus(401)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }

    public function tests_creating_video_without_parameters_expected_422()
    {
        $this->json(self::METHOD, self::URL, [], $this->get_auth_header())
             ->assertStatus(422)
             ->assertJsonStructure($this->creating_validation_error_structure([
	             	'trim_from',
	             	'trim_to',
	             	'video'
             	]));
    }

    public function tests_creating_video_with_wrong_parameters_expected_422()
    {

        $this->json(self::METHOD, self::URL, ['trim_to'=>-1, 'trim_from'=>-1, 'video'=> -1], $this->get_auth_header())
             ->assertStatus(422)
             ->assertJsonStructure($this->creating_validation_error_structure([
	             	'trim_from',
	             	'trim_to',
	             	'video'
             	]));
    }

    public function tests_creating_video_with_trim_to_is_more_than_trim_from_expected_422()
    {

        $this->json(self::METHOD, self::URL, ['trim_to'=>2, 'trim_from'=>10], $this->get_auth_header())
             ->assertStatus(422)
             ->assertJsonStructure($this->creating_validation_error_structure([
	             	'trim_to',
	             	'video'
             	]));
    }

    public function tests_creating_video_without_trim_with_video_expected_422()
    {

    	$file = $this->getTestingFile('1.flv');

        $this->json(self::METHOD, self::URL, ['video' => $file], $this->get_auth_header())
             ->assertStatus(422)
             ->assertJsonStructure($this->creating_validation_error_structure([
	             	'trim_to',
	             	'trim_from',
             	]));
    }

    public function tests_creating_video_trim_to_bigger_than_video_dduration_expected_422()
    {

    	$file = $this->getTestingFile('1.flv');

        $this->json(self::METHOD, self::URL, ['trim_from'=>1, 'trim_to'=>10,'video' => $file], $this->get_auth_header())
             ->assertStatus(422)
             ->assertJsonStructure($this->creating_validation_error_structure([
	             	'trim_to',
             	]));
    }

    public function tests_creating_video_n_times_all_parameters_expected_201_and_checking_()
    {
    	$times = 5;
    	$this->createVideoByRequest($times);
        $this->assertTrue($this->user->video_processes->count() == $times);				 
    }


    protected function createVideoByRequest($times = 1)
    {
    	$file = $this->getTestingFile('1.flv');

    	while ($times--) {
    		$trim_from = rand(1,2);
    		$trim_to = rand($trim_from + 1, 5);
    		$this->json(self::METHOD, self::URL, ['trim_from' => $trim_from, 'trim_to' => $trim_to, 'video' => $file], $this->get_auth_header())
	             ->assertStatus(201)
	             ->assertJsonStructure([
	             		'message'
	             	]);
    	}
        
    }



    
}

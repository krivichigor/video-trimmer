<?php

namespace Tests\Feature;

use App\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoGetTest extends ApiTestCase
{
	const URL    = 'api/v1/videos';
	const METHOD = 'GET';
    
    
    public function tests_get_videos_without_auth_expected_401()
    {
        $this->json(self::METHOD, self::URL)
             ->assertStatus(401)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }

    public function tests_get_videos_with_wrong_auth_401()
    {
        $this->json(self::METHOD, self::URL, [], ['Authorization' => 'Test'])
             ->assertStatus(401)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }


    public function tests_get_videos_allright_expects_200()
    {
        $this->json(self::METHOD, self::URL, [], ['Authorization' => 'Bearer ' . $this->get_api_token()])
             ->assertStatus(200)
             ->assertJsonStructure([
                 "total",
                 "per_page",
                 "current_page",
                 "last_page",
                 "next_page_url",
                 "prev_page_url",
                 "from",
                 "to",
                 "data",
             ]);
    }


    public function tests_get_videos_wrong_page_value_expects_422()
    {
        $this->json(self::METHOD, self::URL . '?page=-1', [], ['Authorization' => 'Bearer ' . $this->get_api_token()])
             ->assertStatus(422)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }

    public function tests_get_videos_wrong_page_letters_value_expects_422()
    {
        $this->json(self::METHOD, self::URL . '?page=asd', [], ['Authorization' => 'Bearer ' . $this->get_api_token()])
             ->assertStatus(422)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }

    



    
}

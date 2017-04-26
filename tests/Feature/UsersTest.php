<?php

namespace Tests\Feature;

use App\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends ApiTestCase
{
    const URL    = 'api/v1/users';
    const METHOD = 'POST';

    public function tests_creating_new_user_respons_201()
    {
        $response = $this->json(self::METHOD, self::URL);
        $response->assertStatus(201);
    }

    public function tests_creating_new_user_json_structure()
    {
        $this->json(self::METHOD, self::URL)
             ->assertJsonStructure([
                 'data' => [
                     'api_token'
                 ]
             ]);
    }

    public function tests_check_new_user_exists_in_database()
    {

        $content = $this->json(self::METHOD, self::URL)->decodeResponseJson();

        $token = $content['data']['api_token'];

        $this->assertDatabaseHas('users_collection', [
            'api_token' => $token
        ]);
      
    }
}

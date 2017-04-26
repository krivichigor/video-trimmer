<?php

namespace Tests\Feature;

use App\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoPutTest extends ApiTestCase
{
	const URL    = 'api/v1/videos';
	const METHOD = 'PUT';
    
    
    public function tests_put_videos_without_auth_expected_401()
    {
        $this->json(self::METHOD, $this->getUrl(str_random(5)))
             ->assertStatus(401)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }

    public function tests_put_video_with_wrong_auth_401()
    {
        $this->json(self::METHOD, $this->getUrl(str_random(5)), [], ['Authorization' => 'Test'])
             ->assertStatus(401)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }

    public function tests_put_video_with_right_auth_wrong_id_expects_404()
    {
        $this->json(self::METHOD, $this->getUrl(str_random(5)), [], $this->get_auth_header())
             ->assertStatus(404)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }

    public function tests_put_video_with_right_auth_and_not_users_video_id_expects_404()
    {
        $header = $this->get_auth_header();
        $video_process = \App\VideoProcess::where('user_id', '<>', $this->user->_id)->get()->first();

        $this->json(self::METHOD, $this->getUrl($video_process->_id), [], $header)
             ->assertStatus(404)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }


    public function tests_put_video_has_wrong_status_expects_404()
    {
        $header = $this->get_auth_header();

        $video_process = $this->createVideoProcess();

        $this->json(self::METHOD, $this->getUrl($video_process->_id), [], $header)
             ->assertStatus(409)
             ->assertJsonStructure([
                 'error' => [
                     'message'
                 ]
             ]);
    }

    public function tests_put_video_all_right_expects_202()
    {
        $header = $this->get_auth_header();

        $video_process = $this->createVideoProcess();
        $video_process->setStatusFailed();

        $this->json(self::METHOD, $this->getUrl($video_process->_id), [], $header)
             ->assertStatus(202)
             ->assertJsonStructure([
                 'message'
             ]);
    }



    protected function getUrl($id)
    {
        return self::URL . '/' . $id;
    }


    protected function createVideoProcess()
    {
        return $this->user->createVideoProcess([
            'trim_from' => 1,
            'trim_to' => 3,
            'video' => $this->getTestingFile('1.flv')
        ]);
    }

    



    
}

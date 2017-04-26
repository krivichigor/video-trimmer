<?php

namespace Tests;

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class ApiTestCase extends TestCase
{

    public function get_auth_header(){
    	return ['Authorization' => 'Bearer ' . $this->get_api_token()];
    }

    public function creating_validation_error_structure(array $details)
    {
    	return [
	         'error' => [
	             'message',
	             'details' => $details
	         ]
	    ];
    }

    public function get_api_token()
    {
    	$user = new User;
    	$user->api_token = $user->generateUniqueApiToken();
    	$user->save();
    	return $user->api_token;
    }

    public function getTestingFile($fileName)
    {
        $filePath = __DIR__ . '/_stubs/';
        return $this->getFile($fileName, $filePath, 'video/x-flv', null);
    }

    protected function getFile($fileName, $stubDirPath, $mimeType = null, $size = null)
    {
        $file =  $stubDirPath . $fileName;

        return new UploadedFile($file, $fileName, $mimeType, $size, $error = null, $testMode = true);
    }

    
}

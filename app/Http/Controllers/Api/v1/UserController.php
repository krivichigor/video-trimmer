<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function store()
    {
    	// Generating unique api_token
    	while (User::find($api_token = str_random(60))) {
    		$api_token = str_random(60);
    	}

    	$user = User::create(['api_token' => $api_token]);

    	return response()->json(['api_token' => $api_token]);
        
    }
}

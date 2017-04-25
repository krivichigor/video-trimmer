<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function store()
    {
   	
    	$user = new User;
    	$user->api_token = $user->generateUniqueApiToken();
    	$user->save();

    	return response()->json(['api_token' => $user->api_token]);
        
    }
}

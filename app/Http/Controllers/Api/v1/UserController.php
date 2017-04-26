<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\v1\Transformers\UserTransformer;

class UserController extends Controller
{
	protected $transformer;

    public function __construct(UserTransformer $userTransormer)
    {
        $this->transformer = $userTransormer;
    }

    public function store()
    {
   	
    	$user = User::create();

    	return response()->json(['data' => $this->transformer->transform($user)], 201);
        
    }
}

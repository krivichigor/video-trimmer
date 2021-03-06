<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function formatValidationErrors(Validator $validator)
    {
    	
        return [
	        'error' => [
		        'message' => 'Validation failed',
		        'details' => $validator->errors()
	        ]
        ];
    }

    protected function errorJson($message = '', $code = 404)
    {
        return response()->json([
                'error' => [
                    'message' => $message,
                ]
            ], $code);   
    }
}

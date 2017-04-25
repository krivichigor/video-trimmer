<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoProcess;

class VideoController extends Controller
{
    public function store(StoreVideoProcess $request)
    {
   	
    	dd($request->all());
        
    }
}

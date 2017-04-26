<?php

namespace App\Http\Controllers\Api\v1;

use App\VideoProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{

    public function index(Request $request)
    {

        $this->validate($request, [
            'page' => 'numeric|min:1', // |max:' . $videos->lastPage() - validation of the max value. 
        ]);

        $user_id = $request->user()->id;

        $videos = VideoProcess::byUser($user_id)
                              ->ordered()
                              ->withVideos()
                              ->paginate(env('RESULTS_PER_PAGE', 10));
                              
        return response()->json([
            $videos
        ]);
    }


	/*
	* 
	*/
    public function store(Request $request)
    {

        $this->validate($request, [
            'trim_from' => 'required|numeric|min:0',
            'trim_to'   => 'required|numeric|min:0|greater_than_field:trim_from',
            'video'     => 'required|max:102400|duration_less_than_field:trim_to|mimetypes:video/avi,video/mpeg,video/quicktime,video/x-flv'
        ]);

        $user = $request->user();

        $videoProcess = $user->video_processes()->create($request->except('video'));
        $videoProcess->saveOriginalVideo($request['video']);
        $videoProcess->setDefaultStatus();
        $videoProcess->save();
        
        return response()->json([
            'message' => 'Trimming is scheduled',
        ], 201);
	
    }


    public function  update(Request $request, $id)
    {
        $video_process = VideoProcess::where('_id', $id)
            ->byUser($request->user()->id)
            ->get()
            ->first();

        if (!$video_process)
            return $this->errorJson('User do not have video process with this id');

        if (!$video_process->canBeRestarted())
            return $this->errorJson('VideoProcess has status \'' . $video_process->status .'\' and can not be restarted', 409);

        $video_process->setDefaultStatus();

        return response()->json([
            'message' => 'Trimming is scheduled',
        ], 202);
            
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

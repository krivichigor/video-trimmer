<?php

namespace App\Http\Controllers\Api\v1\Transformers;
use Carbon\Carbon;

class VideoTransformer extends Transformer{

    public function transform($item)
    {
        return [
            'id' 				=> $item['_id'],
            'trim_from' 		=> floatval($item['trim_from']),
            'trim_to' 			=> floatval($item['trim_to']),
            'status' 			=> $item['status'] ?? null,
            'error_message' 	=> $item['error_message'] ?? null,
            'original_video' 	=> $item['original_video'] ?? null,
            'result_video' 		=> $item['result_video'] ?? null,
            'trim_finished_at'  => isset($item['trim_finished_at']) ? Carbon::parse($item['trim_finished_at'])->timestamp : null,
            'created_at' 		=> Carbon::parse($item['created_at'])->timestamp ?? null,
        ];
    }
    
}
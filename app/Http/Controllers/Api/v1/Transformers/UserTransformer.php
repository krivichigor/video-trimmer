<?php

namespace App\Http\Controllers\Api\v1\Transformers;

class UserTransformer extends Transformer{

    public function transform($item)
    {
        return [
            'api_token' => $item['api_token'],
        ];
    }
    
}
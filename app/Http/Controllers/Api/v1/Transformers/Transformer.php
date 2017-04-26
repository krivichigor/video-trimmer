<?php

namespace App\Http\Controllers\Api\v1\Transformers;

abstract class Transformer{

	public function transformArray(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    public abstract  function transform($item);

}
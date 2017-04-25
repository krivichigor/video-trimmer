<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoProcess extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trim_from' => 'required|numeric|min:0',
            'trim_to' => 'required|numeric|min:0|greater_than_field:trim_from',
            'video' => 'required|mimetypes:video/avi,video/mpeg,video/quicktime,video/x-flv'
        ];
    }
}

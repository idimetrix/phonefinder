<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->method() === 'POST' ? $required = 'required|' : $required = '';

        return [
            'location'      => $required . 'string',
            'prefix'        => $required . 'string',
            'dialing_code'  => $required . 'string',
            'number_format' => $required . 'string'
        ];
    }
}

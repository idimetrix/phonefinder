<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->method() === 'POST' ? $required = 'required|' : $required = '';

        return ['value' => $required . 'string'];
    }
}

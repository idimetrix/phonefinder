<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'number'  => 'required|min:5|max:32',
            'name'    => 'required|min:2|max:128',
            'email'   => 'required|email',
            'type'    => 'required|max:128',
            'message' => 'required|min:3|max:1024',
            'rating'  => 'integer|min:0|max:5',
        ];
    }
}

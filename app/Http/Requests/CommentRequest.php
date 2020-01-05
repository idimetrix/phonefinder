<?php

namespace App\Http\Requests;

use App\Models\Phone;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public $phone;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->phone = Phone::where('short_number', $this->route('number'))->first();

        return !!$this->phone;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'min:2|max:128',
            'type'    => 'max:128',
            'message' => 'required|min:3|max:1024',
        ];
    }
}

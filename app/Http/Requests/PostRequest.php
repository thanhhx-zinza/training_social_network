<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckLimitImages;
use Illuminate\Http\Request;

class PostRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'content' => 'bail|required|max:240',
            'audience' => 'bail|required|alpha',
            "images.*" => "image|mimes:jpeg,png,jpg|max:5120",
            "images" => [new CheckLimitImages($request)],
        ];
    }
}

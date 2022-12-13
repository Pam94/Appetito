<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'time' => 'required|time',
            'portions' => 'required|tinyInteger',
            'instructions' => 'required|longText',
            'favorite' => 'required|boolean',
            'url' => 'optional|string',
            'video' => 'optional|string',
            'user_id' => 'required|unsignedBigInteger',
            'ingredients' => 'present|array',
            'ingredients.*.id' => 'required|unsignedBigInteger',
            'ingredients.*.grams' => 'required|integer'
        ];
    }
}

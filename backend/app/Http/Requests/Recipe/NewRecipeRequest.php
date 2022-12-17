<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewRecipeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'time' => 'required|numeric',
            'portions' => 'required|numeric',
            'instructions' => 'required|string',
            'favorite' => 'sometimes|boolean',
            'url' => 'sometimes|url',
            'video' => 'sometimes|file',
            'images' => 'present|array',
            'images.*.id' => 'required|numeric',
            'categories' => 'present|array',
            'categories.*.id' => 'required|numeric',
            'ingredients' => 'present|array',
            'ingredients.*.id' => 'required|numeric',
            'ingredients.*.grams' => 'required|numeric'
        ];
    }
}

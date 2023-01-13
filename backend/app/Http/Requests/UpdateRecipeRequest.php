<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'time' => 'sometimes|numeric',
            'portions' => 'sometimes|numeric',
            'instructions' => 'sometimes|string',
            'favorite' => 'sometimes|boolean',
            'url' => 'sometimes|url',
            'image' => 'sometimes|image',
            'categories' => 'sometimes|present|array',
            'categories.*.id' => 'required|numeric',
            'ingredients' => 'sometimes|present|array',
            'ingredients.*.id' => 'required|numeric',
            'ingredients.*.grams' => 'sometimes|numeric'
        ];
    }
}

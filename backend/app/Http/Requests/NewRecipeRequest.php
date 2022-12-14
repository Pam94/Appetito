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
            'time' => 'required|integer',
            'portions' => 'required|integer',
            'instructions' => 'required|string',
            'favorite' => 'optional|boolean',
            'url' => 'optional|string',
            'video' => 'optional|string',
            'images' => 'present|array',
            'images.*.id' => 'required',
            'categories' => 'present|array',
            'categories.*.id' => 'required',
            'ingredients' => 'present|array',
            'ingredients.*.id' => 'required',
            'ingredients.*.grams' => 'required|integer'
        ];
    }
}

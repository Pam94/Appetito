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
            'name' => 'optional|string',
            'time' => 'optional|integer',
            'portions' => 'optional|integer',
            'instructions' => 'optional|string',
            'favorite' => 'optional|boolean',
            'url' => 'optional|string',
            'video' => 'optional|string',
            'images' => 'present|array',
            'images.*.id' => 'optional',
            'categories' => 'present|array',
            'categories.*.id' => 'optional',
            'ingredients' => 'present|array',
            'ingredients.*.id' => 'optional',
            'ingredients.*.grams' => 'optional|integer'
        ];
    }
}

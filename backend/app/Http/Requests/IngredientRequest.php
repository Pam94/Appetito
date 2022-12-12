<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest
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
            'icon' => 'optional|binary',
            'pantry' => 'optional|boolean',
            'shoplist' => 'optional|boolean',
            'ingredient_category_id' => 'required|unsignedBigInteger'
        ];
    }
}

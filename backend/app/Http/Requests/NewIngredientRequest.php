<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewIngredientRequest extends FormRequest
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
            'pantry' => 'sometimes|boolean',
            'shoplist' => 'sometimes|boolean',
            'ingredient_category_id' => 'required|numeric'
        ];
    }
}

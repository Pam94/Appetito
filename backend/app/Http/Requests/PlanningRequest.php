<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanningRequest extends FormRequest
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
            'date' => 'required|date',
            'user_id' => 'required|unsignedBigInteger',
            'recipes' => 'present|array',
            'recipes.*.id' => 'required|unsignedBigInteger',
            'recipes.*.meal' => 'required|enum'
        ];
    }
}
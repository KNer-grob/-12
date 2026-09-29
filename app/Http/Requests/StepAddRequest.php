<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StepAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "description" => "required",
            "image_url" => "image",
            "recipe_id" => "required|exists:recipes,id",
            "step_number" => "required|integer",

        ];
    }
}

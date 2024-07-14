<?php

namespace App\Http\Requests\API\Facility;

use App\Facades\MessageFixer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|max:100",
            "description" => "required|max:255",
            "features" => "required|array",
            "features.*.icon" => "required|max:20",
            "features.*.name" => "required|max:50",
            "image" => "required|image|max:5120|mimes:png,jpg,jpeg,webp",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = new MessageFixer([
            'code' => MessageFixer::HTTP_UNPROCESSABLE_ENTITY,
            'status' => MessageFixer::WARNING,
            'messages' => $validator->errors(),
        ], MessageFixer::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}

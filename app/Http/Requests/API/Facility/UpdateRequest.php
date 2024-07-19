<?php

namespace App\Http\Requests\API\Facility;

use App\Facades\MessageFixer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
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
            "features.*" => "required|max:50",
            "image" => "image|max:5120|mimes:png,jpg,jpeg",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $reformattedErrors = [
            'title' => $errors['title'] ?? [],
            'description' => $errors['description'] ?? [],
            'image' => $errors['image'] ?? [],
            'features' => [],
        ];

        foreach ($errors as $key => $messages) {
            if (strpos($key, 'features.') === 0) {
                preg_match('/features\.(\d+)/', $key, $matches);
                $index = $matches[1];

                $reformattedErrors['features'][$index] = $messages;
            }
        }

        $response = new MessageFixer([
            'code' => MessageFixer::HTTP_UNPROCESSABLE_ENTITY,
            'status' => MessageFixer::WARNING,
            'messages' => $reformattedErrors,
        ], MessageFixer::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}

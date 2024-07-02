<?php

namespace App\Http\Requests\API\Room;

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
            'title' => 'required|max:100',
            'description' => 'required|max:500',
            'features' => 'required|array',
            'features.*.type' => 'required|in:1,2,3',
            'features.*.name' => 'required|max:75',
            'images' => 'required|array|max:4',
            'images.*' => 'image|mimes:png,jpg,jpeg|max:5120'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $reformattedErrors = [
            'title' => $errors['title'] ?? [],
            'description' => $errors['description'] ?? [],
            'images' => $errors['images'] ?? [],
            'features' => [],
        ];

        foreach ($errors as $key => $messages) {
            if (strpos($key, 'features.') === 0) {
                preg_match('/features\.(\d+)\.(type|name)/', $key, $matches);
                $index = $matches[1];
                $field = $matches[2];

                if (!isset($reformattedErrors['features'][$index])) {
                    $reformattedErrors['features'][$index] = [];
                }

                $reformattedErrors['features'][$index][$field] = $messages;
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

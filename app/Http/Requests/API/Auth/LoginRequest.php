<?php

namespace App\Http\Requests\API\Auth;

use App\Facades\MessageFixer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6|max:100'
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

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class SignUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s]+$/u', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
        ];
    }

    /**
     * Get the validation that apply to the request APIs.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $isJsonRequest = request()->is('api/*');
        if ($isJsonRequest) {
            throw new HttpResponseException(jsonFormat($validator->errors(), 'errors', JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        } else {
            parent::failedValidation($validator);
        }
    }

}

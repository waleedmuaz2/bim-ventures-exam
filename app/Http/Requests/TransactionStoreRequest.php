<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class TransactionStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|decimal:2',
            'payer' => 'required|exists:users,id',
            'due_on' => 'required|date',
            'vat' => 'required|min:1|max:99.99',
            'is_vat_inclusive' => 'required|in:yes,no',
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
            throw new HttpResponseException(jsonFormat($validator->errors(),'errors',JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        } else {
            parent::failedValidation($validator);
        }
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;
use Pearl\RequestValidate\RequestAbstract;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Controllers\Traits\ApiResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends RequestAbstract
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            //
        ];
    }

    protected function failedValidation(Validator $validator): ValidationException
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException($this->sendApiResponse(false,"validation error",$errors,'1001'));

    }
}

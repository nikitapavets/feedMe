<?php

namespace FeedMe\Http\Requests;

use FeedMe\Providers\ResponseServiceProvider;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class Request extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()
            ->json($validator->errors(), ResponseServiceProvider::HTTP_RESPONSE_BAD_REQUEST));
    }

    public function messages()
    {
        return [];
    }

    public function rules() {
        return [];
    }
}

<?php

namespace App\Traits;

use App\Exceptions\BadRequestException;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\APIResponse;

/**
 * 
 */
trait APIRequest
{
    use  APIResponse;
    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestException($validator->errors()->first());
    }
}
    
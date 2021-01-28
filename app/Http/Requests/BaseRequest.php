<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Common\ErrCode;

class BaseRequest extends FormRequest
{
    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw(new HttpResponseException(response()->json([
            'code' => ErrCode::PARAMS_ERROR,
            'msg' => $validator->errors()->first(),
            'data' => []
        ], 200)));

        //throw new ValidationException($validator);
    }

    /**
     * @return bool
     */
    public function expectsJson()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function wantsJson()
    {
        return true;
    }
}

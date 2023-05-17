<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ruleWorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'right_leave' => 'numeric',
            'time_right_leave' => 'numeric',
            'max_overtime' => 'numeric',
            'traffic_time_limit' => 'numeric',
            'limit_forgotten' => 'numeric',
            'forgotten_traffic_count' => 'numeric',
            'overtime_overlap' => 'numeric',
            'overcalculation' => 'numeric',


        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }
}

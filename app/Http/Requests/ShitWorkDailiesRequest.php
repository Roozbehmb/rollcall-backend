<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class ShitWorkDailiesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'attending_more_appointed_time' => 'string',
            'subject_to_rest' => 'string|required_with:attending_more_appointed_time',
            'rest_period' => 'string|required_with:attending_more_appointed_time',
            'title' => 'required|unique:shift_dailies,title' . $this->id,
            'description' => 'required',
            'one_turn_work_shift' => 'required|numeric',
        ];

    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success' => false,

            'message' => 'Validation errors',

            'data' => $validator->errors()

        ]));

    }


}

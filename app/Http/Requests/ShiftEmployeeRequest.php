<?php

namespace App\Http\Requests;

use App\Models\ShiftEmployee;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ShiftEmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $array = [
            'id_user' => 'required',
        ];

        if (empty($this->request->get('shift_dailies_id'))) {
            if (empty($this->request->get('shift_dailies_date_up')) && empty($this->request->get('shift_dailies_date_at'))) {
                $array = [
                    'shift_dailies_date_up' => 'nullable',
                    'shift_dailies_id' => 'nullable',
                    'shift_dailies_date_at' => 'nullable'
                ];
            }
        } else {
            if (empty($this->request->get('shift_dailies_date_up')) || empty($this->request->get('shift_dailies_date_at'))) {
                return $array = [
                    'shift_dailies_id' => 'required',
                    'shift_dailies_date_up' => 'required',
                    'shift_dailies_date_at' => 'required'
                ];
            }
        }           ////////check validation value shift_dailies_id
        if (empty($this->request->get('week_shift_id'))) {
            if (empty($this->request->get('week_shifts_date_up')) && empty($this->request->get('week_shifts_date_at'))) {
                $array = [
                    'week_shifts_date_at' => 'nullable',
                    'week_shift_id' => 'nullable',
                    'week_shifts_date_up' => 'nullable'
                ];
            } else {
                if (empty($this->request->get('week_shifts_date_up')) || empty($this->request->get('week_shifts_date_at'))) {
                    return $array = [
                        'week_shifts_date_at' => 'required',
                        'week_shift_id' => 'required',
                        'week_shifts_date_up' => 'required'
                    ];
                }
            }

        } else {
            if (empty($this->request->get('week_shifts_date_up')) || empty($this->request->get('week_shifts_date_at'))) {
                return $array = [
                    'week_shifts_date_at' => 'required',
                    'week_shift_id' => 'required',
                    'week_shifts_date_up' => 'required'
                ];
            }
        }              ////////check validation value week_shift_id
        if (empty($this->request->get('periodic_shift_id'))) {
            if (empty($this->request->get('periodic_shifts_date_up')) && empty($this->request->get('periodic_shifts_date_at'))) {
                $array = [
                    'periodic_shifts_date_up' => 'nullable',
                    'periodic_shifts_date_at' => 'nullable',
                    'periodic_shift_id' => 'nullable'
                ];
            }
        } else {
            if (empty($this->request->get('periodic_shifts_date_up')) || empty($this->request->get('periodic_shifts_date_at'))) {
                return $array = [
                    'periodic_shifts_date_up' => 'required',
                    'periodic_shifts_date_at' => 'required',
                    'periodic_shift_id' => 'required'
                ];
            }
        }          ////////check validation value periodic_shifts_date_up
        if (empty($this->request->get('dedicated_shift_id'))) {
            if (empty($this->request->get('dedicated_shifts_date_up')) && empty($this->request->get('dedicated_shifts_date_at'))) {
                $array = [
                    'dedicated_shifts_date_up' => 'nullable',
                    'dedicated_shifts_date_at' => 'nullable',
                    'dedicated_shift_id' => 'nullable'
                ];
            }
        } else {
            if (empty($this->request->get('dedicated_shifts_date_up')) || empty($this->request->get('dedicated_shifts_date_at'))) {
                return $array = [
                    'dedicated_shifts_date_up' => 'nullable',
                    'dedicated_shifts_date_at' => 'nullable',
                    'dedicated_shift_id' => 'nullable'
                ];
            }
        }         ////////check validation value dedicated_shift_id







        return $array;
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


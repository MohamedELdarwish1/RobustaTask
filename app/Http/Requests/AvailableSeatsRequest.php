<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class AvailableSeatsRequest extends FormRequest
{
    // public function authorize()
    // {
    //     return true;
    // }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_station_id'  => ['required','integer','exists:App\Models\Station,id'],
            'end_station_id'  => ['required','integer','exists:stations,id'],
        ];
    }

    public function withValidator($validator)
    {

       self::validationErrorResponse($validator, 'Some inputs do not conform to the rules');
    }

    static function validationErrorResponse($validator, $message)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'message' => $message,
                    'errors' => $validator->errors(),
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    }

}

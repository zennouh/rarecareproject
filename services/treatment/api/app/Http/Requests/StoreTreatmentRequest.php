<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTreatmentRequest
{
    public static function rules()
    {
        return [
            'patient_id'      => 'required|integer',
            'medication_name' => 'required|string|max:255',
            'dosage'          => 'required|string',
            'frequency'       => 'required|string',
            'start_date'      => 'required|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'status'          => 'in:active,completed,cancelled',
        ];
    }

    public static function validate(Request $request)
    {
        $validator = Validator::make($request->all(), self::rules());

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'errors' => $validator->errors()
            ], 422));
        }

        return $validator->validate();
    }
}

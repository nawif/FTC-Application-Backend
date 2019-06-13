<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreWork extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_id' => 'required|exists:events,id',
            'description' => 'required|min:10|max:255'
        ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

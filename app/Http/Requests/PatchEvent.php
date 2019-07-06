<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PatchEvent extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:events,id',
            'name' => 'required',
            'description' => 'required|min:15|max:200',
            'whatsapp_url' => '',
            'date' =>'',
            'user_limit' => 'required',
            'type' => ['required', Rule::in(['ORGANIZE', 'ATTEND'])],
            'registered_users.*' => 'exists:users,id',
            'notify' =>'',
        ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

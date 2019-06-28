<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'active_url' => 'required',
            'leader_id' => 'required|exists:users,id',
            'description' => 'required|min:15|max:200',
            'user_limit' => 'required',
            'date' => 'required',
            'type' => ['required', Rule::in(['ORGANIZE', 'ATTEND'])],
        ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

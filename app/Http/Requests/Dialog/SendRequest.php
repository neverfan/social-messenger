<?php

namespace App\Http\Requests\Dialog;

use App\Http\Requests\ApiRequest;

class SendRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'to_user_id' => 'integer|nullable',
            'message' => 'required|string|max:1000',
        ];
    }
}

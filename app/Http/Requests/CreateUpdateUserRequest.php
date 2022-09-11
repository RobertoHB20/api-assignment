<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'nullable|string' ,
            'avatar' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attribute is required',
            'email.email' => ":attribute doesn't have a correct format",

            'first_name.required' => ':attribute is required',
            'first_name.string' => ":attribute doesn't have a correct format",

            'last_name.string' => ":attribute doesn't have a correct format",
            'avatar.url' => ":attribute doesn't have a correct format",
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'avatar' => 'Avatar',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException( response()->json([
            'errors' => $validator->errors()
        ], 422) );
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetUsersRequest extends FormRequest
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
            'page' => 'sometimes|numeric|min:1'
        ];
    }

    public function messages()
    {
        return [
            'page.numeric' => ":attribute doesn't have required format",
            'page.min' => ":attribute doesn't accomplish minimum value"
        ];
    }

    public function attributes()
    {
        return [
            'page' => 'Page attribute'
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException( response()->json([
            'errors' => $validator->errors()
        ], 422) );
    }
}

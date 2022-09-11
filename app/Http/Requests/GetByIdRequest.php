<?php

namespace App\Http\Requests;

use App\Services\ConsumersService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetByIdRequest extends FormRequest
{

    private $validationService;

    public function __construct(ConsumersService $service)
    {
        $this->validationService = $service;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $auth = $this->header('Authorization', null);
        if(!$auth){
            return false;
        }
        try {
            $auth = explode(' ', $auth)[1];
            $credentials = explode( ':', base64_decode($auth) );
            $isValid = $this->validationService->validateConsumer($credentials[0],$credentials[1]);
            if($isValid){
                return true;
            }
            return false;
        }catch(\Exception $e){
            return false;
        }
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
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException( response()->json([
            'errors' => $validator->errors()
        ], 422) );
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException( response()->json([
            'message' => 'This action is unauthorized'
        ], 403) );
    }
}

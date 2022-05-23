<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|string|max:100',            
            'email' => 'required|string|email|max:100',
            'password' => 'required|min:6',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Имя пользователя должно быть заполнено!',
            'name.max' => 'Имя пользователя не должно быть длинее, чем 100 знаков!',            
            'email.required' => 'email пользователя должно быть указан!',
            'email.email' => 'Email должен быть как email!',
            'password.required' => 'У пользователя должен быть заполнен пароль!',            
            'password.min' => 'Пароль пользователя должен состоять не менее чем из 6 символов!',
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            new JsonResponse($validator->messages(), 422)
        );
    }
}
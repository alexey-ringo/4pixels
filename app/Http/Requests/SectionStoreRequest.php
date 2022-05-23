<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SectionStoreRequest extends FormRequest
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
            'name' => 'required|string|max:100|unique:sections',            
            'description' => 'required|string|max:250',
            'logo' => 'required|string',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Название отдела должно быть заполнено!',
            'name.max' => 'Название отдела не должно быть длинее, чем 100 знаков!',
            'name.unique' => 'Название отдела должно быть уникальным!',
            'description.required' => 'Описание отдела должно быть заполнено!',
            'description.max' => 'Описание отдела не должно быть длинее, чем 100 знаков!',
            'logo.required' => 'Изображение отдела должно быть подгружено!',                         
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            new JsonResponse($validator->messages(), 422)
        );
    }
}
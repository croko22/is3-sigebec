<?php

namespace App\Http\Requests\Beca;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['sometimes','required', 'string','nullable'],
            'descripcion' => ['sometimes','required', 'string','nullable'],
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es requerido',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto',
            'descripcion.required' => 'El campo descripción es requerido',
            'descripcion.string' => 'El campo descripción debe ser una cadena de texto',
        ];
    }
    public function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json([
         'success'   => false,
         'message'   => 'Error de validación',
         'data'      => $validator->errors()
       ],400));
    }
}
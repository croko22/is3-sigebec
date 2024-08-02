<?php

namespace App\Http\Requests\Convocatoria;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateRequest extends FormRequest
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
            'descripcion' => ['required', 'string',],
            'inicio' => ['required', 'date','before:fin'],
            'fin' => ['required', 'date','after:inicio'],
            'beca_id' => ['required', 'exists:scholarships,id'],
        ];
    }
    public function messages():array
    {
        return [
            'descripcion.required' => 'La descripción es requerida',
            'descripcion.string' => 'La descripción debe ser un texto',
            'inicio.required' => 'La fecha de inicio es requerida',
            'inicio.date' => 'La fecha de inicio debe ser una fecha',
            'inicio.before' => 'La fecha de inicio debe ser anterior a la fecha de fin',
            'fin.required' => 'La fecha de fin es requerida',
            'fin.date' => 'La fecha de fin debe ser una fecha',
            'fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio',
            'beca_id.required' => 'La beca es requerida',
            'beca_id.exists' => 'La beca no existe',
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
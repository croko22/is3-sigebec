<?php

namespace App\Http\Requests\Convocatoria;

use Illuminate\Foundation\Http\FormRequest;

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
            'descripcion' => ['string',],
            'inicio' => ['date','before:fin'],
            'fin' => ['date','after:inicio'],
            'beca_id' => ['exists:scholarships,id'],
        ];
    }
    public function messages():array
    {
        return [
            'descripcion.string' => 'La descripción debe ser un texto',
            'inicio.date' => 'La fecha de inicio debe ser una fecha',
            'inicio.before' => 'La fecha de inicio debe ser anterior a la fecha de fin',
            'fin.date' => 'La fecha de fin debe ser una fecha',
            'fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio',
            'beca_id.exists' => 'La beca no existe',
        ];
    }
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
       throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
         'success'   => false,
         'message'   => 'Error de validación',
         'data'      => $validator->errors()
       ],400));
    }
}
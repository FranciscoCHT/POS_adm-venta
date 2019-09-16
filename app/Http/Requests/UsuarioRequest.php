<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            //'rol' => 'required|string',
            'rut' => 'required|string',
            'telefono' => 'string',
            'email' => 'required|string|email|max:255|unique:usuario',
            'password' => 'required|string|min:4|confirmed',
        ];
    }
}

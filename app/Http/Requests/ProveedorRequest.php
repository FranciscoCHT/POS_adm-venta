<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
            'empresa'=>'max:100',
            'nombre'=>'required|max:100',
            'telefono'=>'max:100',
            'descripcion'=>'max:1000',
            'correo'=>'max:100',
        ];
    }
}

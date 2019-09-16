<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'nombre'=>'required|max:200',
            'descripcion'=>'max:1000',
            'imagen'=>'mimes:jpeg,bmp,png',
            //'stock'=>'required|numeric',
            'cod_barra'=>'max:1000',
            'precio'=>'numeric',
            //'porc_ganancia'=>'max:100',
        ];
    }
}

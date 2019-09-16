<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
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
            'proveedor_id'=>'required',
            //'fecha_compra'=>'required',
            'total_compra'=>'max:20|required',
            'iva'=>'required',
            //'numero_documento'=>'max:20',
            //'codigo_barra'=>'max:1000',
            //'cantidad'=>'required',
            //'total_linea'=>'required'
        ];
    }
}

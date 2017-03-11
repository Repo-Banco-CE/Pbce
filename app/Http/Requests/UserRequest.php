<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nombre'    => 'min:4 | max:120 | required',
            'direccion' => 'min:6 | max:120 | required',
            'telefono'  => 'min:10 | max:20 | required',
            'email'     => 'min:6 | max:250 | required | unique:users',
            'password'  => 'min:5 | max:250 | required | confirmed',
            'rif'       => 'min:7 | max:8 | unique:juridicas',
            'cedula'    => 'min:7 | max:8 | unique:naturales'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    protected $errorBag = 'StoreCountryForm';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|alpha:ascii|max:255|unique:countries,name',
            'ISO' => 'required|alpha:ascii|size:2|unique:countries,ISO'
        ];
    }
}

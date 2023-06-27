<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
{
    protected $errorBag = 'UpdateCountryForm';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|alpha:ascii|max:255|unique:countries,name,' . $this->country->id,
            'ISO' => 'required|alpha:ascii|size:2|unique:countries,ISO,' . $this->country->id
        ];
    }
}

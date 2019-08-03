<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'    => 'required',
            'email'   => 'nullable|email',
            'logo'    => 'nullable|file|image|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|url',
        ];
    }
}

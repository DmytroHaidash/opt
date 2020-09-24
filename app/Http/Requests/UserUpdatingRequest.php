<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdatingRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|string|regex:/^\+?38[\d\-\s]{10,15}$/',
            'type_car' => 'required_if:role,carrier',
            'brand_car' => 'required_if:role,carrier',
            'tonnage' => 'required_if:role,carrier',
            'price_km' => 'required_if:role,carrier',
        ];
    }
}

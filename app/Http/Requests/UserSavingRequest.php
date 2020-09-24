<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSavingRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,' . request('user_id') . ',id',
            'phone' => 'required|string|regex:/^\+?38[\d\-\s]{10,15}$/',
            'password' => ['required_if:change_password,on', 'string', 'min:8', 'confirmed'],
            'city_id' => 'required|numeric',
            'type_car' => 'required_if:role,carrier',
            'brand_car' => 'required_if:role,carrier',
            'tonnage' => 'required_if:role,carrier',
            'price_km' => 'required_if:role,carrier',
        ];
    }

    public function attributes()
    {
        return [
            'phone' => 'телефона'
        ];
    }
}

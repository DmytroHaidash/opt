<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderSavingRequest extends FormRequest
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
        $rules = [];

        if (!\Auth::check()) {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users',
                'phone' => 'required|string|regex:/^\+?38[\d\-\s]{10,15}$/'
            ]);
        }

        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class TickerCreationRequest extends FormRequest
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
        $rules = [
            'subject' => 'required|string|in:' . implode(',', Ticket::$SUBJECTS),
            'message' => 'required|string'
        ];

        if (!\Auth::check()) {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:191',
                'phone' => 'required|string|regex:/^\+?38[\d\-\s]{10,13}$/'
            ]);
        }

        return $rules;
    }
}

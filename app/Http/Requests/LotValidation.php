<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LotValidation extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bid' => 'required',
            'price' => 'nullable',
            'item' => 'required',
            'time' => 'required|in:12,24,36,48,60,72',
        ];
    }
}

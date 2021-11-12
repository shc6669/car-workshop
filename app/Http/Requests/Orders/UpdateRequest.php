<?php

namespace Vanguard\Http\Requests\Orders;

use Vanguard\Http\Requests\Request;

class UpdateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'car_id'        => 'required',
            'start_at'      => 'required'
        ];
    }

    public function messages()
    {
        return [
            'car_id.required'   => 'Car is required',
            'start_at.required' => 'Start date is required'
        ];
    }
}

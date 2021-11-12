<?php

namespace Vanguard\Http\Requests\Orders;

use Vanguard\Http\Requests\Request;

class CreateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'car_id'        => 'required|unique:t_orders,car_id',
            'mechanic_id'   => 'required',
            'start_at'      => 'required'
        ];
    }

    public function messages()
    {
        return [
            'car_id.required'   => 'Car is required',
            'car_id.unique'     => 'This car has already selected. Please select other',
            'mechanic_id'       => 'Mechanic is required',
            'start_at.required' => 'Start date is required'
        ];
    }
}

<?php

namespace Vanguard\Http\Requests\MasterData;

use Vanguard\Http\Requests\Request;

class CarsCreatedUpdatedRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|unique:m_cars,user_id'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required'  => 'Car owner is required',
            'user_id.unique'    => 'This car owner has already selected. Please select other'
        ];
    }
}

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
            'licence_plate' => 'required|unique:m_cars,licence_plate',
            'name'          => 'required',
            'user_id'       => 'required'
        ];
    }

    public function messages()
    {
        return [
            'licence_plate.required'    => 'Licence plate is required',
            'licence_plate.unique'      => 'This licence plate has already registered to system, please input others',
            'name.required'             => 'Car name is required',
            'user_id.required'          => 'Car owner is required'
        ];
    }
}

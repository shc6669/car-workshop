<?php

namespace Vanguard\Http\Requests\MasterData;

use Vanguard\Http\Requests\Request;

class MechanicsCreatedUpdatedRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|unique:m_mechanics,user_id'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required'  => 'Mechanic is required',
            'user_id.unique'    => 'This mechanic has already selected. Please select other'
        ];
    }
}

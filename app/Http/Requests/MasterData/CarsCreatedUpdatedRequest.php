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
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required|min:6|confirmed',
        ];
    }
}

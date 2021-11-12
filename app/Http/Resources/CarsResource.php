<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'car_owner_name'    => $this->user->first_name.' '.$this->user->last_name,
            'car_name'          => $this->name,
            'car_licence_plate' => $this->licence_plate
        ];
    }
}

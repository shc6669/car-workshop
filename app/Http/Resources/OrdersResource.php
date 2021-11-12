<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
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
            'car_owner'         => $this->car->user->first_name. ' '.$this->car->user->last_name,
            'car_license_plate' => $this->car->licence_plate,
            'car_type'          => $this->car->name
        ];
    }
}

<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobsResource extends JsonResource
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
            'handled_by'    => $this->mechanic->user->first_name.' '.$this->mechanic->user->last_name,
            'car_owner'     => $this->order->car->user->first_name.' '.$this->order->car->user->last_name,
            'status'        => $this->status
        ];
    }
}

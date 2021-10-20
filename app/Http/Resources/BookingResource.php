<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'bay_id'  => $this->bay_id,
            'bay'     => BayResource::make($this->whenLoaded('bay')),
            'user_id' => $this->user_id,
            'user'    => UserResource::make($this->whenLoaded('user')),

            'start_time' => $this->start_time,
            'paid_at'    => $this->paid_at,
        ];
    }
}

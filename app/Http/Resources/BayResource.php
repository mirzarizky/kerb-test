<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BayResource extends JsonResource
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
            'user_id' => $this->user_id,
            'owner'   => UserResource::make($this->whenLoaded('owner')),

            'name'        => $this->name,
            'is_occupied' => $this->is_occupied,
        ];
    }
}

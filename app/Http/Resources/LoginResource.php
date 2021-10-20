<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function __construct(protected User $user)
    {
        //
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->user->id,
            'name'              => $this->user->name,
            'email'             => $this->user->email,
            'access_token'      => $this->generateAccessToken(),
        ];
    }

    protected function generateAccessToken()
    {
        return $this->user->createToken('Login Access')->plainTextToken;
    }
}

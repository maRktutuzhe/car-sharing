<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'middle_name' => $this->resource->middle_name,
            'last_name' => $this->resource->last_name,
            'full_name' => $this->resource->fullName(),
            'email' => $this->resource->email,
            'phone_number' => $this->resource->phone_number,
            'city' => $this->resource->city,
            'passport' => $this->resource->passport,
            'licence' => $this->resource->licence,
        ];

        return $response;
    }
}

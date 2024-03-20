<?php

namespace App\Http\Resources\Rent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentResource extends JsonResource
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
            'user_id' => $this->resource->user_id,
            'car_id' => $this->resource->car_id,
            'event' => $this->resource->event,
            'petrol' => $this->resource->petrol,
            'location_id' => $this->resource->location_id,
            'kilometer' => $this->resource->kilometer,
        ];

        return $response;
    }
}

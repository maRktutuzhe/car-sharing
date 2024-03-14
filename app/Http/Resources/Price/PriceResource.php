<?php

namespace App\Http\Resources\Price;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            'car_id' => $this->resource->car_id,
            'minute' => $this->resource->minute,
            'day' => $this->resource->day,
        ];

        return $response;
    }
}

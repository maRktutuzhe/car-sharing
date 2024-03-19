<?php

namespace App\Http\Resources\Location;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class LocationResource extends JsonResource
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
            'coordinates' => $this->resource->coordinates,
            'date_time' => $this->resource->updated_at,
        ];

        return $response;
    }
}

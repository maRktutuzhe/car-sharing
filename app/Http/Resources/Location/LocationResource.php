<?php

namespace App\Http\Resources\Location;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        $location = Location::withCoordinates($this->resource->id)->first();
        $coordinates = json_decode($location->coordinates, true)['coordinates'];

        $response = [
            'id' => $this->resource->id,
            'car_id' => $this->resource->car_id,
            'coordinates' => $coordinates,
            'date_time' => $this->resource->updated_at,
        ];

        return $response;
    }
}

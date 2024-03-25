<?php

namespace App\Http\Resources\Location;

use App\Casts\GeoJson;
use App\Models\Location;
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
    
    // $coordinates = json_decode($c, true);
    public function toArray(Request $request): array
    {
        $geoJson = new GeoJson();
        $coordinates = $geoJson->get(null, null, $this->resource->id, null);

        $response = [
            'id' => $this->resource->id,
            'car_id' => $this->resource->car_id,
            'coordinates' => $coordinates,
            'date_time' => $this->resource->updated_at,
        ];

        return $response;
    }
}

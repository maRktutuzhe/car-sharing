<?php

namespace App\Http\Resources\State;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
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
            'doors' => $this->resource->doors,
            'engine' => $this->resource->engine,
            'block' => $this->resource->block,
        ];

        return $response;
    }
}

<?php

namespace App\Http\Resources\CarMake;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarMakeResource extends JsonResource
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
            'name' => $this->resource->name,
            'country' => $this->resource->country,
        ];

        return $response;
    }
}

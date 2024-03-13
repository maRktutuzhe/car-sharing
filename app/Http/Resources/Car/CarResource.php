<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'carmake_id' => $this->resource->carmake_id,
            'name' => $this->resource->name,
            'number' => $this->resource->number,
            'color' => $this->resource->color,
            'status' => $this->resource->status,
            'damages' => $this->resource->damages,
            'STS' => $this->resource->STS,
            'PTS' => $this->resource->PTS,
        ];

        return $response;
    }
}

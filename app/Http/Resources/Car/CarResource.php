<?php

namespace App\Http\Resources\Car;

use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\Rent\RentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    // public $resource;


    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'carmake_id' => $this->resource->carMake->name,
            'name' => $this->name,
            'number' => $this->number,
            'color' => $this->color,
            'status' => $this->status,
            'damages' => $this->damages,
            'STS' => $this->STS,
            'PTS' => $this->PTS,
        ];



        $includes = (array)$request->input('include', []);

        if (in_array('location', $includes)) {
            $response['location'] = new LocationResource($this->resource->locations->last());
        }
        if (in_array('rent', $includes)) {
            $response['rent'] = new RentResource($this->resource->rents->last());
            $response['price'] = $this->resource->price->minute;

        }
        return $response;
    }
}

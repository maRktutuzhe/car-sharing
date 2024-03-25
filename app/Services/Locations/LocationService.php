<?php

namespace App\Services\Locations;

use App\Casts\GeoJson;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Models\Location;

class LocationService
{
    /**
     * Создание локации
     * 
     * @param StoreLocationRequest $data
     * @return Location
     */
    public function storeLocation (StoreLocationRequest $data): Location
    {
        
        $data = $data->validated();

        $latitude = $data['coordinates']['latitude'];
        $longitude = $data['coordinates']['longitude'];
        
        $geoJson = new GeoJson();
        $coordinates = $geoJson->set(null, null, "$latitude $longitude", []);

        $data['coordinates'] = $coordinates;

        $location = Location::query()->create($data);

        return $location;
    }

    /**
     * изменение локации
     * 
     * @param UpdateLocationRequest $data
     * @return Location
     */
    public function updateLocation (UpdateLocationRequest $data, Location $location): Location
    {
        
        $data = $data->validated();

        if (isset($data['coordinates'])) {
            $latitude = $data['coordinates']['latitude'];
            $longitude = $data['coordinates']['longitude'];
            
            $geoJson = new GeoJson();
            $coordinates = $geoJson->set(null, null, "$latitude $longitude", []);
            
            $data['coordinates'] = $coordinates;
        }

        $location->update($data);

        return $location;
    }
}

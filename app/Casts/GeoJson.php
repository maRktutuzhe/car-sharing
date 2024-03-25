<?php

namespace App\Casts;

use App\Models\Location;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\DB;

class GeoJson implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get($model,  $key,  $id,  $attributes): mixed
    {
        $location = Location::withCoordinates($id)->first();
        $coordinates = json_decode($location->coordinates, true)['coordinates'];

        return $coordinates;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set($model, $key, $value, $attributes): mixed
    {
        return DB::raw("ST_GeomFromText('POINT($value)', 4326)");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

/**
 * Модель марки машины
 * 
 * @package App\Models\Location
 * @property string $car_id
 * @property string $coordinates
 * @property string $created_at
 * @property string $updated_at
 */
class Location extends Model
{
    use HasFactory;
    use HasUuids;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'car_id',
        'coordinates',
    ];

    public function scopeWithCoordinates($query, $id)
    {
        return $query
            ->addSelect(DB::raw('ST_AsGeoJSON(coordinates) as coordinates'))
            ->where('id', $id);
    }

    /**
     * Get the Car
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}

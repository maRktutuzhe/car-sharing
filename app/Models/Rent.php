<?php

namespace App\Models;

use App\Enums\Event;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель Аренды
 *
 * @package App\Models\Rent
 * @property string $id
 * @property string $user_id
 * @property string $car_id
 * @property string $event
 * @property float $petrol
 * @property string $location_id
 * @property float $kilometer
 * @property string $created_at
 * @property string $updated_at
 */
class Rent extends Model
{
    use HasFactory;
    use HasUuids;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'car_id',
        'event',
        'petrol',
        'location_id',
        'kilometer',
    ];
    protected $enumCasts = [
        'event' => Event::class,
    ];
}

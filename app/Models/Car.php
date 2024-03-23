<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Модель машины
 *
 * @package App\Models\Car
 * @property string $id
 * @property string $carmake_id
 * @property string $name
 * @property string $number
 * @property string $color
 * @property string $status
 * @property array $damages
 * @property string $STS
 * @property string $PTS
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * 
 * @method locations
 * @method fullName
 */
class Car extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'carmake_id',
        'name',
        'number',
        'color',
        'status',
        'damages',
        'STS',
        'PTS',
    ];

    /**
     * Get the full name
     */
    public function fullName(): string
    {
        return $this->color . ' ' . $this->carMake->name . ' ' . $this->name . ' ' . $this->number;
    }


    /**
     * Get the Car Make
     */
    public function carMake(): BelongsTo
    {
        return $this->belongsTo(CarMake::class, 'carmake_id');
    }
    
    /**
     * Get the price
     */
    public function price(): HasOne
    {
        return $this->hasOne(Price::class);
    }
 
    /**
     * Get the state
     */
    public function state(): HasOne
    {
        return $this->hasOne(State::class);
    }

    /**
     * Get the locations
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
    
    /**
     * Get the rents
     */
    public function rents(): HasMany
    {
        return $this->hasMany(Rent::class);
    }
}

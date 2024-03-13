<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Модель марки машины
 * 
 * @package App\Models\CarMake
 * @property string $name
 * @property string $country
 * @property string $created_at
 * @property string $updated_at
 */
class CarMake extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'country',
    ];

    /**
     * Get the cars
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}

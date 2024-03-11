<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

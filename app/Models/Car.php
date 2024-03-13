<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
     * Get the Car Make
     */
    public function carMake(): BelongsTo
    {
        return $this->belongsTo(CarMake::class);
    }
}

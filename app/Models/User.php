<?php

namespace App\Models;

use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Модель пользователя
 *
 * @package App\Models\User
 * @property string $id
 * @property string $organization_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property string $phone_number
 * @property string $city
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @method string fullName()
 */
class User extends Authenticatable implements JWTSubject
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
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_number',
        'city',
        'password',
        'status',
        'balance',
    ];

    protected $enumCasts = [
        'status' => UserStatus::class,
    ];

    /**
     * Возвращает полное имя пользователя.
     *
     * @return string
     */
    public function fullName(): string
    {
        return $this->middle_name . ' ' . $this->first_name . ' ' . $this->last_name;
    }
        
    /**
     * Получает идентификатор пользователя для хранения в поле "subject" токена JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Возвращает дополнительные данные, которые будут добавлены к токену JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}

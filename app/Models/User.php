<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_number',
        'city',
        'password',
    ];
    /**
     * @return string
     */
    public function fullName(): string
    {
        return $this->middle_name . ' ' . $this->first_name . ' ' . $this->last_name;
    }
}

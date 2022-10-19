<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $email
 * @property string $password
 * @property Car $car
 * @property UserCar $userCar
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function car(): HasOneThrough
    {
        return $this->hasOneThrough(
            Car::class,
            UserCar::class,
            'user_id',
            'id',
            'id',
            'car_id'
        );
    }

    public function userCar(): HasOne
    {
        return  $this->hasOne(UserCar::class);
    }
}

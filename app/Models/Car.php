<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string|null $state_number
 * @property int $car_model_id
 * @property CarModel $carModel
 * @property UserCar $userCar
 */
class Car extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'state_number',
        'car_model_id'
    ];

    public function userCar(): HasOne
    {
        return $this->hasOne(UserCar::class);
    }

    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }

    public function scopeForModel(Builder $builder, CarModel $carModel): Builder
    {
        return $builder->where('car_model_id', $carModel->id);
    }
}

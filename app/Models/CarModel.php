<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $title
 * @property int $car_brand_id
 * @property CarBrand $carBrand
 */
class CarModel extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'car_brand_id',
    ];

    public function carBrand(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}

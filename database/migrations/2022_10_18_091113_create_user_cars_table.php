<?php

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_cars', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Car::class)->constrained()->cascadeOnDelete();
            $table->unique(['user_id', 'car_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_cars');
    }
};

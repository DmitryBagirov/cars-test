<?php

namespace App\Console\Commands;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Console\Command;

class InitCarModelCommand extends Command
{
    protected $signature = 'cars:init-models';

    protected $description = 'Create cer brands with models';

    private array $brands = [
        'Toyota' => ['Camry', 'Avensis', 'Estima', 'Alphard', 'Rav4'],
        'Honda' => ['Accord', 'Civic', 'Odyssey'],
    ];

    public function handle(): int
    {
        collect($this->brands)
            ->each(function (array $models, string $brand) {
                /** @var CarBrand $brandModel */
                $brandModel = CarBrand::query()
                    ->where('title', 'ilike', $brand)
                    ->firstOrCreate(values: ['title' => $brand]);

                collect($models)
                    ->each(fn(string $model) => CarModel::query()
                        ->where('title', 'ilike', $model)
                        ->where('car_brand_id', $brandModel->id)
                        ->firstOrCreate(values: [
                            'title' => $model,
                            'car_brand_id' => $brandModel->id
                        ])
                    );
            });

        return Command::SUCCESS;
    }
}

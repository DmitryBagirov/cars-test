<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Console\Command;

class GenerateCarsCommand extends Command
{
    protected $signature = 'cars:generate';
    protected $description = 'Generate cars';

    public function handle(): int
    {
        CarModel::all()->each(function (CarModel $carModel) {
            for ($i = 0; $i < 10; ++$i) {
                Car::query()->create([
                    'car_model_id' => $carModel->id,
                    'state_number' => $this->randomStateNumber(),
                ]);
            }
        });

        return Command::SUCCESS;
    }

    private function randomStateNumber(): string
    {
        $series1 = $this->randomString(1);
        $num = sprintf('%03d', random_int(0, 999));
        $series2 = $this->randomString(2);
        $regionNum = sprintf('%02d', random_int(0, 99));

        return "$series1$num$series2$regionNum";
    }

    private function randomString(int $len): string
    {
        $letters = mb_str_split('АВЕКМНОРСТУХ');
        $result = '';

        for ($i = 0; $i < $len; ++$i) {
            $result .= $letters[random_int(0, count($letters) - 1)];
        }

        return $result;
    }
}

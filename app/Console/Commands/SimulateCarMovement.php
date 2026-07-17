<?php

namespace App\Console\Commands;

use App\Enums\CarsStatus;
use App\Events\CarMoved;
use App\Models\Car;
use Illuminate\Console\Command;

class SimulateCarMovement extends Command
{
    protected $signature = 'cars:simulate-movement
                            {--interval=2 : Seconds to wait between movement ticks}
                            {--step=0.0006 : Maximum degrees a car can drift per tick}';

    protected $description = 'Continuously nudges every rented car\'s virtual coordinates and broadcasts the new position';

    private const LAT_MIN = 55.70;
    private const LAT_MAX = 55.88;
    private const LNG_MIN = 37.37;
    private const LNG_MAX = 37.58;

    public function handle(): int
    {
        $interval = (int) $this->option('interval');
        $step = (float) $this->option('step');

        $this->info("Simulating car movement every {$interval}s (max step {$step}°). Press Ctrl+C to stop.");

        while (true) {
            Car::query()
                ->where('status', CarsStatus::Rented)
                ->each(function (Car $car) use ($step) {
                    $latitude = $this->drift($car->latitude, $step, self::LAT_MIN, self::LAT_MAX);
                    $longitude = $this->drift($car->longitude, $step, self::LNG_MIN, self::LNG_MAX);

                    $car->setCoordinates($latitude, $longitude);
                    $car->saveQuietly();

                    event(new CarMoved($car));
                });

            sleep($interval);
        }
    }

    private function drift(float $value, float $step, float $min, float $max): float
    {
        $next = $value + random_int(-1000, 1000) / 1000 * $step;

        return max($min, min($max, $next));
    }
}

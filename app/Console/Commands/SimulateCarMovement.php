<?php

namespace App\Console\Commands;

use App\Enums\CarsStatus;
use App\Jobs\UpdateCarLocation;
use App\Models\Car;
use Illuminate\Console\Command;

class SimulateCarMovement extends Command
{
    protected $signature = 'cars:simulate-movement
                            {--interval=2 : Seconds to wait between movement ticks}
                            {--step=0.0006 : Maximum degrees a car can drift per tick}';

    protected $description = 'Continuously nudges every rented car\'s virtual coordinates and publishes the new position to RabbitMQ';

    private const LAT_MIN = 55.70;
    private const LAT_MAX = 55.88;
    private const LNG_MIN = 37.37;
    private const LNG_MAX = 37.58;

    public function handle(): int
    {
        $interval = (int) $this->option('interval');
        $step = (float) $this->option('step');

        $this->info("Publishing car movement every {$interval}s (max step {$step}°) to RabbitMQ. Press Ctrl+C to stop.");

        while (true) {
            Car::query()
                ->where('status', CarsStatus::Rented)
                ->each(function (Car $car) use ($step) {
                    $latitude = $this->drift($car->latitude, $step, self::LAT_MIN, self::LAT_MAX);
                    $longitude = $this->drift($car->longitude, $step, self::LNG_MIN, self::LNG_MAX);

                    UpdateCarLocation::dispatch($car->id, $latitude, $longitude)->onConnection('rabbitmq');
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

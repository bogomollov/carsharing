<?php

namespace App\Jobs;

use App\Events\CarMoved;
use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCarLocation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(
        public string $carId,
        public float $latitude,
        public float $longitude,
    ) {}

    public function handle(): void
    {
        $car = Car::find($this->carId);

        if (! $car) {
            return;
        }

        $car->setCoordinates($this->latitude, $this->longitude);
        $car->saveQuietly();

        event(new CarMoved($car));
    }
}

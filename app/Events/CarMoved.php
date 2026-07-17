<?php

namespace App\Events;

use App\Models\Car;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class CarMoved implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(
        public Car $car,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('cars-tracking'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'CarMoved';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->car->id,
            'latitude' => $this->car->latitude,
            'longitude' => $this->car->longitude,
        ];
    }
}

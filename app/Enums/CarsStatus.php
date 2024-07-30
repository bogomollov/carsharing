<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CarsStatus extends Enum
{
    const Rented = 'rented';
    const Maintenance = 'maintenance';
    const Expectation = 'expectation';
}

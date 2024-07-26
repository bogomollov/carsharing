<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CarsStatus extends Enum
{
    const Rented = 'rented';
    const Maintenance = 'maintenance';
    const Expectation = 'expectation';
}

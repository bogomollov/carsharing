<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CarsStatus extends Enum
{
    const Rented = 'rented';
    const Maintenance = 'maintenance';
    const Expectation = 'expectation';
}

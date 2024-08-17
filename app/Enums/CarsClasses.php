<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CarsClasses extends Enum
{
    const Premium = 'premium';
    const Business = 'business';
    const Comfort = 'comfort';
    const Economy = 'economy';
}

<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DrivesType extends Enum
{
    const FullDrive = 'full';
    const FrontDrive = 'front';
    const RearDrive = 'rear';
}

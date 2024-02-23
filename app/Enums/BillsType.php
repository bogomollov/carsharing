<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BillsType extends Enum
{
    const Personal = 'personal';
    const Corporated = 'corporated';
}

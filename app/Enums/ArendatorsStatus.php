<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ArendatorsStatus extends Enum
{
    const Deleted = 'deleted';
    const Blocked = 'blocked';
    const Frozen = 'frozen';
    const Active = 'active';
}

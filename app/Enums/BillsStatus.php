<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BillsStatus extends Enum
{
    const Closed = 'closed';
    const Blocked = 'blocked';
    const Frozen = 'frozen';
    const Open = 'open';
}

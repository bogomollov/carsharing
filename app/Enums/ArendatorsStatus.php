<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ArendatorsStatus extends Enum
{
    const Deleted = 'deleted';
    const Blocked = 'blocked';
    const Frozen = 'frozen';
    const Active = 'active';
}

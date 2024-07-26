<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class BillsStatus extends Enum
{
    const Closed = 'closed';
    const Blocked = 'blocked';
    const Frozen = 'frozen';
    const Open = 'open';
}

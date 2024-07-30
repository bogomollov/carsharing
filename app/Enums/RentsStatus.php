<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RentsStatus extends Enum
{
    const Closed = 'closed';
    const Open = 'open';
}

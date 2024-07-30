<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class FuelsType extends Enum
{
    const Gasoline = 'gasoline';
    const Diesel = 'diesel';
    const Hybrid = 'hybrid';
    const Plugin_Hybrid = 'plugin-hybrid';
    const Electric = 'electric';
}

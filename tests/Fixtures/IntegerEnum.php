<?php

declare(strict_types=1);

namespace JDecool\Enum\Tests\Fixtures;

use JDecool\Enum\Enum;

/**
 * @method static static FIRST()
 * @method static static SECOND()
 */
class IntegerEnum extends Enum
{
    private const FIRST = 1;
    private const SECOND = 2;
}

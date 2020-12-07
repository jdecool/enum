<?php

declare(strict_types=1);

namespace JDecool\Enum\Tests\Fixtures;

use JDecool\Enum\Enum;

/**
 * @method static static FOO()
 * @method static static BAR()
 */
class PrivateEnum extends Enum
{
    private const FOO = 'foo_value';
    private const BAR = 'bar_value';
}

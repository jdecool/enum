<?php

declare(strict_types=1);

namespace JDecool\Enum\Tests\Fixtures;

use JDecool\Enum\Enum;

/**
 * @method static static FOO()
 * @method static static BAR()
 */
class ProtectedEnum extends Enum
{
    protected const FOO = 'foo_value';
    protected const BAR = 'bar_value';
}

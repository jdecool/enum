<?php

declare(strict_types=1);

namespace JDecool\Enum\Tests\Fixtures;

use JDecool\Enum\Enum;

/**
 * @method static static FOO()
 * @method static static BAR()
 */
class PublicEnum extends Enum
{
    public const FOO = 'foo_value';
    public const BAR = 'bar_value';
}

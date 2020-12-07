Enum
====

An another Enum implementation for PHP.

## Why ?

Why creating an another enum package ?

I usually use two enum implementations depends on my needs: [myclabs/php-enum](https://github.com/myclabs/php-enum/) or [marc-mabe/php-enum](https://github.com/marc-mabe/php-enum).

I appreciate the first one `myclabs/php-enum` for its simplicity, but it has a big default: two access to the same enum value doesn't return the same class instance.

That's why, I sometimes use the second one `marc-mabe/php-enum` but its disadvantage is that is not possible to have private constant to represent our enum values. So those constant are publicly exposed.

This is why I've decided to create my own enum implementation, which have the simplicity of `myclabs/php-enum` with the power of `marc-mabe/php-enum`.

## Installation

This library require PHP >= 8.0, you can easily install it using [Composer](https://getcomposer.org).

```bash
composer require jdecool/enum
```

## Declaration

```php
use JDecool\Enum\Enum;

class MyEnum extends Enum
{
    public const ENUM_1 = 'value_1';
    protected const ENUM_2 = 'value_2';
    private const ENUM_3 = 'value_3';
}
```

## Usage

```php
$value1 = MyEnum::ENUM_1();
$value2 = MyEnum::ENUM_2();
$value3 = MyEnum::ENUM_3();
```

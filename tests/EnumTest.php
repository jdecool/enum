<?php

declare(strict_types=1);

namespace JDecool\Enum\Tests;

use InvalidArgumentException;
use JDecool\Enum\{
    Enum,
    Tests\Fixtures\IntegerEnum,
    Tests\Fixtures\PrivateEnum,
    Tests\Fixtures\ProtectedEnum,
    Tests\Fixtures\PublicEnum,
};
use LogicException;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testNamedConstructorOf(): void
    {
        $foo = PrivateEnum::of('foo_value');
        static::assertInstanceOf(PrivateEnum::class, $foo);
        static::assertSame(PrivateEnum::FOO(), $foo);

        $first = IntegerEnum::of(1);
        static::assertInstanceOf(IntegerEnum::class, $first);
        static::assertSame(IntegerEnum::FIRST(), $first);
    }

    public function testAnExceptionThrowsOnUnknownValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PrivateEnum::of('unknown');
    }

    public function testEnumAccessWithPublicValues(): void
    {
        $foo = PublicEnum::FOO();
        $bar = PublicEnum::BAR();

        static::assertInstanceOf(Enum::class, $foo);
        static::assertInstanceOf(Enum::class, $bar);

        static::assertInstanceOf(PublicEnum::class, $foo);
        static::assertInstanceOf(PublicEnum::class, $bar);

        static::assertNotEquals($foo, $bar);
    }

    public function testEnumAccessWithProtectedValues(): void
    {
        $foo = ProtectedEnum::FOO();
        $bar = ProtectedEnum::BAR();

        static::assertInstanceOf(Enum::class, $foo);
        static::assertInstanceOf(Enum::class, $bar);

        static::assertInstanceOf(ProtectedEnum::class, $foo);
        static::assertInstanceOf(ProtectedEnum::class, $bar);

        static::assertNotEquals($foo, $bar);
    }

    public function testEnumAccessWithPrivateValues(): void
    {
        $foo = PrivateEnum::FOO();
        $bar = PrivateEnum::BAR();

        static::assertInstanceOf(Enum::class, $foo);
        static::assertInstanceOf(Enum::class, $bar);

        static::assertInstanceOf(PrivateEnum::class, $foo);
        static::assertInstanceOf(PrivateEnum::class, $bar);

        static::assertNotEquals($foo, $bar);
    }

    public function testAnExceptionThrowsOnUsingUnknownValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        PrivateEnum::UNKNOWN();
    }

    public function testGetKey(): void
    {
        static::assertSame('FOO', PublicEnum::FOO()->getKey());
        static::assertSame('BAR', ProtectedEnum::BAR()->getKey());
        static::assertSame('BAR', PrivateEnum::BAR()->getKey());
        static::assertSame('FIRST', IntegerEnum::FIRST()->getKey());
    }

    public function testGetValue(): void
    {
        static::assertSame('foo_value', PublicEnum::FOO()->getValue());
        static::assertSame('bar_value', ProtectedEnum::BAR()->getValue());
        static::assertSame('bar_value', PrivateEnum::BAR()->getValue());
        static::assertSame(1, IntegerEnum::FIRST()->getValue());
    }

    public function testSameEnumValueOnDifferentClassNotConflict(): void
    {
        static::assertSame(PublicEnum::FOO(), PublicEnum::FOO());
        static::assertNotSame(PublicEnum::FOO(), PrivateEnum::FOO());
    }

    public function testEqualsMethod(): void
    {
        static::assertTrue(PublicEnum::FOO()->equals(PublicEnum::FOO()));
        static::assertFalse(PublicEnum::FOO()->equals(PrivateEnum::FOO()));
    }

    public function testAnExceptionThrowOnEnumCloning(): void
    {
        $foo = PublicEnum::FOO();

        $this->expectException(LogicException::class);

        clone $foo;
    }

    public function testAnExceptionThrowOnEnumSerialization(): void
    {
        $foo = PublicEnum::FOO();

        $this->expectException(LogicException::class);

        serialize($foo);
    }

    public function testIsValid(): void
    {
        static::assertTrue(PublicEnum::isValid('foo_value'));
    }

    public function testIsValidOnUnknownValue(): void
    {
        static::assertFalse(PublicEnum::isValid('unknown'));
    }

    public function testArrayTransformation(): void
    {
        $values = PublicEnum::values();
        static::assertIsArray($values);
        static::assertSame($values['FOO'], PublicEnum::FOO());
        static::assertSame($values['BAR'], PublicEnum::BAR());

        $values = PrivateEnum::values();
        static::assertIsArray($values);
        static::assertSame($values['FOO'], PrivateEnum::FOO());
        static::assertSame($values['BAR'], PrivateEnum::BAR());
    }

    public function testMatchEvaluation(): void
    {
        $value = ProtectedEnum::FOO();
        $result = match ($value) {
            ProtectedEnum::FOO() => true,
            default => false,
        };

        static::assertTrue($result);
    }
}

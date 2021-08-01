<?php

declare(strict_types=1);

namespace JDecool\Enum;

use BackedEnum;
use InvalidArgumentException;
use LogicException;
use ReflectionClass;
use ValueError;
use function array_search;

abstract class Enum implements BackedEnum
{
    private static array $cache = [];
    private static array $instances = [];

    public string $name;
    public string $value;

    private string|int|float $internalValue;

    public static function from(int|string $scalar): static
    {
        try {
            return self::of($scalar);
        } catch (InvalidArgumentException $e) {
            throw new ValueError($e->getMessage(), $e->getCode(), $e);
        }
    }

    public static function tryFrom(int|string $scalar): ?static
    {
        try {
            return self::of($scalar);
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * @return static[]
     */
    public static function cases(): array
    {
        return array_values(static::values());
    }

    /**
     * @deprecated use Enum::from instead
     */
    public static function of(string|int|float $value): static
    {
        @trigger_error('The Enum::of method is deprecated, use Enum::from instead.', \E_USER_DEPRECATED);

        $key = static::search($value);

        return static::byKey($key);
    }

    public static function isValid(string|int|float $value): bool
    {
        try {
            static::search($value);
        } catch (InvalidArgumentException) {
            return false;
        }

        return true;
    }

    /**
     * @return array<string, static>
     */
    public static function values(): array
    {
        $array = [];
        foreach (static::toArray() as $constant) {
            $enum = static::of($constant);
            $array[$enum->getKey()] = $enum;
        }

        return $array;
    }

    private static function byKey(string $key): static
    {
        if (isset(self::$instances[static::class][$key])) {
            return self::$instances[static::class][$key];
        }

        $constants = static::toArray();
        if (!isset($constants[$key])) {
            $const = static::class."::$key";
            throw new InvalidArgumentException("{$const} not defined");
        }

        self::$instances[static::class][$key] = new static($key, $constants[$key]);

        return self::$instances[static::class][$key];
    }

    private static function search(string|int|float $value): string
    {
        $key = array_search($value, static::toArray(), true);
        if (false === $key) {
            $class = static::class;
            throw new InvalidArgumentException("Unknow value '$value' for enum '$class'");
        }

        return $key;
    }

    private static function toArray(): array
    {
        $class = static::class;
        if (!isset(self::$cache[$class])) {
            $reflection = new ReflectionClass(static::class);
            self::$cache[$class] = $reflection->getConstants();
        }

        return self::$cache[$class];
    }

    final private function __construct(string $key, string|int|float $value)
    {
        $this->name = $key;
        $this->value = (string) $value;

        $this->internalValue = $value;
    }

    public function getKey(): string
    {
        return $this->name;
    }

    public function getValue(): string|int|float
    {
        return $this->internalValue;
    }

    public function equals(self $enum): bool
    {
        return $this === $enum;
    }

    final public static function __callStatic(string $key, array $arguments): static
    {
        return static::byKey($key);
    }

    final public function __clone()
    {
        throw new LogicException('Enums are not cloneable');
    }

    final public function __sleep()
    {
        throw new LogicException('Enums are not serializable');
    }

    final public function __wakeup()
    {
        throw new LogicException('Enums are not serializable');
    }
}

<?php

if (\PHP_VERSION_ID < 80100) {
    interface BackedEnum extends UnitEnum
    {
        public static function from(int|string $scalar): static;
        public static function tryFrom(int|string $scalar): ?static;
    }
}

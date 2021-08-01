<?php

if (\PHP_VERSION_ID < 80100) {
    interface UnitEnum
    {
        public static function cases(): array;
    }
}

<?php

namespace Leonardocrcst\QueryBuilder\Utils;

abstract class Formatter
{
    public static function formatValue(mixed $value): string|int|array|float
    {
        if (is_array($value)) {
            return array_map(fn($v) => self::formatValue($v), $value);
        }
        if (is_numeric($value)) {
            return $value;
        }
        return match (gettype($value)) {
            'boolean' => $value ? 'true' : 'false',
            'NULL' => 'NULL',
            default => "'$value'"
        };
    }
}

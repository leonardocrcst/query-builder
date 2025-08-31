<?php

namespace Leonardocrcst\QueryBuilder\Types;

enum ExpressionType: string
{
    case EQUALS = '=';
    case NOT_EQUALS = '!=';
    case AND = 'AND';
    case OR = 'OR';
    case NOT = 'NOT';
    case IN = 'IN';
    case NOT_IN = 'NOT IN';
    case BETWEEN = 'BETWEEN';
    case NOT_BETWEEN = 'NOT BETWEEN';
    case NULL = 'NULL';
    case NOT_NULL = 'NOT NULL';
    case LESS_THAN = '<';
    case LESS_THAN_OR_EQUALS = '<=';
    case GREATER_THAN = '>';
    case GREATER_THAN_OR_EQUALS = '>=';
    case LIKE = 'LIKE';
    case IS = 'IS';
    case IS_NULL = 'IS NULL';
    case IS_NOT_NULL = 'IS NOT NULL';

    public static function getTypesWithoutComparisonValues(): array
    {
        return [
            self::IS_NULL,
            self::IS_NOT_NULL,
        ];
    }
}

<?php

namespace Leonardocrcst\QueryBuilder\Clausules;

use InvalidArgumentException;
use Leonardocrcst\QueryBuilder\Types\ExpressionType;

class WhereClausule
{
    public ?string $getWhere {
        get {
            if (empty($this->clausules)) {
                return null;
            }
            $where = 'WHERE';
            foreach ($this->clausules as $key => $clausule) {
                if ($key > 0) {
                    $where .= ' ' . $this->type[$key];
                }
                $where .= $clausule instanceof WhereClausule
                    ? str_replace('WHERE ', ' (', $clausule->getWhere) . ')'
                    : " $clausule";
            }
            return trim($where);
        }
    }
    private array $clausules = [];
    private array $type = [];

    public function add(WhereClausule $whereClausule, ExpressionType $expressionType): WhereClausule
    {
        if ($expressionType->value !== ExpressionType::AND->value && $expressionType->value !== ExpressionType::OR->value) {
            throw new InvalidArgumentException("Tipo não suportado ($expressionType->value)");
        }
        $this->clausules[] = $whereClausule;
        $this->type[] = $expressionType->value;
        return $this;
    }

    public function and(string $column, ExpressionType $expressionType, mixed $value): WhereClausule
    {
        $this->clausules[] = "$column $expressionType->value " . $this->normalizeValue(
                $value,
                $expressionType
            );
        $this->type[] = ExpressionType::AND->value;
        return $this;
    }

    private function normalizeValue(mixed $value, ExpressionType $expressionType): ?string
    {
        if (in_array($expressionType, ExpressionType::getTypesWithoutComparisonValues())) {
            return null;
        }
        if (gettype($value) === 'array') {
            switch ($expressionType->value) {
                case 'BETWEEN':
                case 'NOT BETWEEN':
                    return sprintf(
                        '%s AND %s',
                        $value[0],
                        $value[1]
                    );
                case 'IN':
                case 'NOT IN':
                    return '(' . implode(', ', $this->formatValue($value)) . ')';
            }
        }
        return $this->formatValue($value);
    }

    private function formatValue(mixed $value): string|int|array|float
    {
        if (is_array($value)) {
            return array_map(fn($v) => $this->formatValue($v), $value);
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

    public function or(string $column, ExpressionType $expressionType, mixed $value): WhereClausule
    {
        $this->clausules[] = "$column $expressionType->value " . $this->normalizeValue(
                $value,
                $expressionType
            );
        $this->type[] = ExpressionType::OR->value;
        return $this;
    }
}

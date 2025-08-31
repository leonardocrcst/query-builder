<?php

namespace Leonardocrcst\QueryBuilder;

use Leonardocrcst\QueryBuilder\Utils\Formatter;

class UpdateQueryBuilder
{
    private array $values = [];
    private array $wheres = [];

    public function __construct(
        private readonly string $table
    ) {
    }

    public function value(string $column, mixed $value, string $caseColumn, mixed $whenValue): void
    {
        if (!isset($this->values[$column])) {
            $this->values[$column] = [" = CASE $caseColumn"];
        }
        //$this->values[$column][] = "WHEN '$whenValue' THEN '$value'";
        $this->values[$column][] = sprintf(
            "WHEN %s THEN %s",
            Formatter::formatValue($whenValue),
            Formatter::formatValue($value)
        );
        $this->wheres[$caseColumn][] = $whenValue;
    }

    public function __toString(): string
    {
        return sprintf(
            'UPDATE %s SET %s WHERE %s',
            $this->table,
            $this->getSetQuery(),
            $this->getWhereQuery()
        );
    }

    private function getSetQuery(): string
    {
        $set = [];
        foreach ($this->values as $column => $values) {
            $set[$column] = $column;
            $set[$column] .= implode(" ", $values);
            $set[$column] .= " ELSE $column END";
        }
        return implode(', ', $set);
    }

    private function getWhereQuery(): string
    {
       $where = [];
       foreach ($this->wheres as $column => $values) {
           $where[] = "$column IN (" . implode(", ", array_unique($values)) . ")";
       }
       return implode(' AND ', $where);
    }
}

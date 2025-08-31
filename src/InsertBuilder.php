<?php

namespace Leonardocrcst\QueryBuilder;

class InsertBuilder
{
    private array $rows = [];

    public function __construct(
        private readonly string $table
    ) {
    }

    public function value(string $column, mixed $value, int $row = 0): InsertBuilder
    {
        $this->rows[$row][$column] = $value;
        return $this;
    }

    public function __toString(): string
    {
        return trim(sprintf(
            'INSERT INTO %s (%s) VALUES %s',
            $this->table,
            implode(", ", array_keys($this->rows[0])),
            implode(", ", array_map(fn($row) => sprintf("('%s')", implode("', '", $row)), $this->rows))
        ));
    }
}

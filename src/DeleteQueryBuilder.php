<?php

namespace Leonardocrcst\QueryBuilder;

class DeleteQueryBuilder
{
    private string $column;
    private string $values;

    public function __construct(
        private readonly string $table
    ) {
    }

    public function value(string $column, array $values): DeleteQueryBuilder
    {
        $this->column = $column;
        $this->values = sprintf(
            '"%s"',
            implode('", "', $values)
        );
        return $this;
    }

    public function __toString(): string
    {
        return "DELETE FROM $this->table WHERE $this->column IN ($this->values)";
    }
}

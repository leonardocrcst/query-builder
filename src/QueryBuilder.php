<?php

namespace QueryBuilder;

readonly class QueryBuilder
{
    public function __construct(
        private string $table
    ) {
    }

    public function select(): void
    {

    }

    public function insert(array $values): InsertBuilder
    {
        $insert = new InsertBuilder($this->table);
        if (is_numeric(array_keys($values)[0])) {
            foreach ($values as $row => $itens) {
                foreach ($itens as $key => $value) {
                    $insert->value($key, $value, $row);
                }
            }
        }
        return $insert;
    }

    public function update(): void
    {

    }

    public function delete(string $column, array $matches): DeleteBuilder
    {
        return new DeleteBuilder($this->table)->value($column, $matches);
    }
}

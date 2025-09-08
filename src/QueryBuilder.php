<?php

namespace Leonardocrcst\QueryBuilder;

readonly class QueryBuilder
{
    public function __construct(
        private string $table
    ) {
    }

    public function select(?array $columns = null): SelectQueryBuilder
    {
        $select = new SelectQueryBuilder($this->table);
        if (!empty($columns)) {
            foreach ($columns as $column) {
                $select->addColumn($column);
            }
        }
        return $select;
    }

    public function insert(array $values): InsertQueryBuilder
    {
        $insert = new InsertQueryBuilder($this->table);
        if (is_numeric(array_keys($values)[0])) {
            foreach ($values as $row => $itens) {
                foreach ($itens as $key => $value) {
                    $insert->value($key, $value, $row);
                }
            }
        }
        return $insert;
    }

    public function update(): UpdateQueryBuilder
    {
        return new UpdateQueryBuilder($this->table);
    }

    public function delete(string $column, array $matches): DeleteQueryBuilder
    {
        return new DeleteQueryBuilder($this->table)->value($column, $matches);
    }
}

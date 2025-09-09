<?php

namespace Leonardocrcst\QueryBuilder;

use Leonardocrcst\QueryBuilder\Clausules\JoinClausule;
use Leonardocrcst\QueryBuilder\Clausules\LimitClausule;
use Leonardocrcst\QueryBuilder\Clausules\OrderClausule;
use Leonardocrcst\QueryBuilder\Clausules\WhereClausule;
use Leonardocrcst\QueryBuilder\Types\JoinType;

class SelectQueryBuilder
{
    protected OrderClausule $order;
    protected LimitClausule $limit;
    protected WhereClausule $where;
    protected array $joins = [];
    protected array $columns = [];
    protected array $columnsAlias = [];

    protected string $getColumns {
        get {
            if (empty($this->columns)) {
                return '*';
            }
            $columns = [];
            foreach ($this->columns as $column) {
                $columns[] = isset($this->columnsAlias[$column]) ? "$column AS " . $this->columnsAlias[$column] : $column;
            }
            return implode(', ', $columns);
        }
    }

    public WhereClausule $whereClausule {
        set => $this->where = $value;
        get => $this->where;
    }

    protected string $getFrom {
        get => "FROM $this->table";
    }

    public function __construct(
        private readonly string $table
    ) {
        $this->order = new OrderClausule();
        $this->limit = new LimitClausule();
        $this->where = new WhereClausule();
    }

    public function setJoin(JoinType $joinType, string $joinTable): JoinClausule
    {
        $join = new JoinClausule($joinType, $this->table,$joinTable);
        $this->joins[] = $join;
        return $join;
    }

    public function addColumn(string $column, ?string $alias = null): self
    {
        $this->columns[] = $column;
        if (!empty($alias)) {
            $this->columnsAlias[$column] = $alias;
        }
        return $this;
    }

    public function setOrder(string $term, string $direction = 'asc'): OrderClausule
    {
        $this->order->add($term, $direction);
        return $this->order;
    }

    public function setLimit(int $limit, ?int $offset = null): LimitClausule
    {
        if (empty($this->limit)) {
            $this->limit = new LimitClausule();
        }
        $this->limit->limit = $limit;
        if (!empty($offset)) {
            $this->limit->offset = $offset;
        }
        return $this->limit;
    }

    public function __toString(): string
    {
        return trim(sprintf(
            "SELECT %s %s %s %s %s %s",
            $this->getColumns,
            $this->getFrom,
            !empty($this->joins) ? implode(' ', $this->getJoins()) : null,
            $this->where->getWhere,
            $this->order->getOrders,
            $this->limit->getLimit
        ));
    }

    private function getJoins(): array
    {
        return array_map(fn(JoinClausule $join) => $join->getJoin, $this->joins);
    }
}

<?php

namespace Leonardocrcst\QueryBuilder;

use Leonardocrcst\QueryBuilder\Clausules\LimitClausule;
use Leonardocrcst\QueryBuilder\Clausules\OrderClausule;
use Leonardocrcst\QueryBuilder\Clausules\WhereClausule;

class SelectQueryBuilder
{
    protected OrderClausule $order;
    protected LimitClausule $limit;
    protected WhereClausule $where;

    public array $columns {
        set => $this->columns = $value;
    }
    protected string $getColumns {
        get => !empty($this->columns) ? implode(', ', $this->columns) : '*';
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

    public function setOrder(string $term, string $direction = 'asc'): OrderClausule
    {
        if (empty($this->order)) {
            $this->order = new OrderClausule();
        }
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
            "SELECT %s %s %s %s %s",
            $this->getColumns,
            $this->getFrom,
            $this->where->getWhere,
            $this->order->getOrders,
            $this->limit->getLimit
        ));
    }
}

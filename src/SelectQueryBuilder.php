<?php

namespace Leonardocrcst\QueryBuilder;

use Leonardocrcst\QueryBuilder\Clausules\Limit;
use Leonardocrcst\QueryBuilder\Clausules\Order;

class SelectQueryBuilder
{
    protected Order $order;
    protected Limit $limit;
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
        $this->order = new Order();
        $this->limit = new Limit();
    }

    public function setOrder(string $term, string $direction = 'asc'): Order
    {
        if (empty($this->order)) {
            $this->order = new Order();
        }
        $this->order->add($term, $direction);
        return $this->order;
    }

    public function setLimit(int $limit, ?int $offset = null): Limit
    {
        if (empty($this->limit)) {
            $this->limit = new Limit();
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
            "SELECT %s %s %s %s",
            $this->getColumns,
            $this->getFrom,
            $this->order->getOrders,
            $this->limit->getLimit
        ));
    }
}

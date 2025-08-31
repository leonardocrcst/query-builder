<?php

namespace Leonardocrcst\QueryBuilder\Clausules;

class Order
{
    public ?string $getOrders {
        get {
            if (empty($this->orders)) {
                return null;
            }
            return 'ORDER BY ' . implode(', ', $this->orders);
        }
    }

    private array $orders = [];

    public function add(string $term, string $direction = 'asc'): void
    {
        $this->orders[] = "$term $direction";
    }
}

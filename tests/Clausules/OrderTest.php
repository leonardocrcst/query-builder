<?php

namespace Leonardocrcst\Tests\Clausules;

use Leonardocrcst\QueryBuilder\Clausules\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testAddSingleOrder(): void
    {
        $order = new Order();
        $order->add('column');
        $this->assertEquals('ORDER BY column asc', $order->getOrders);
    }

    public function testAddMultipleOrders(): void
    {
        $order = new Order();
        $order->add('column1');
        $order->add('column2', 'desc');
        $this->assertEquals('ORDER BY column1 asc, column2 desc', $order->getOrders);
    }

    public function testEmptyOrders(): void
    {
        $order = new Order();
        $this->assertEquals('', $order->getOrders);
    }
}

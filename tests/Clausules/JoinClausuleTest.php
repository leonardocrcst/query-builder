<?php

namespace Leonardocrcst\Tests\Clausules;

use Leonardocrcst\QueryBuilder\Clausules\JoinClausule;
use Leonardocrcst\QueryBuilder\Types\ExpressionType;
use Leonardocrcst\QueryBuilder\Types\JoinType;
use PHPUnit\Framework\TestCase;

class JoinClausuleTest extends TestCase
{
    public function testJoinClause(): void
    {
        $join = new JoinClausule(JoinType::RIGHT, 'on', 'join');
        $join->add('column_a', ExpressionType::EQUALS, 'column_b', ExpressionType::AND);

        $this->assertEquals("RIGHT JOIN `join` ON `on`.`column_a` = `join`.`column_b`", $join->getJoin);
    }
}

<?php

namespace Leonardocrcst\Tests\Clausules;

use Leonardocrcst\QueryBuilder\Clausules\WhereClausule;
use Leonardocrcst\QueryBuilder\Types\ExpressionType;
use PHPUnit\Framework\TestCase;

class WhereClausuleTest extends TestCase
{
    public function testSingleAndCondition(): void
    {
        $where = new WhereClausule();
        $where->and('name', ExpressionType::EQUALS, 'John');
        $this->assertEquals("WHERE name = 'John'", $where->getWhere);
    }

    public function testSingleOrCondition(): void
    {
        $where = new WhereClausule();
        $where->or('age', ExpressionType::GREATER_THAN, '18');
        $this->assertEquals("WHERE age > 18", $where->getWhere);
    }

    public function testMultipleAndConditions(): void
    {
        $where = new WhereClausule();
        $where->and('name', ExpressionType::EQUALS, 'John')
            ->and('age', ExpressionType::GREATER_THAN, '18');
        $this->assertEquals("WHERE name = 'John' AND age > 18", $where->getWhere);
    }

    public function testMultipleOrConditions(): void
    {
        $where = new WhereClausule();
        $where->or('status', ExpressionType::EQUALS, 'active')
            ->or('status', ExpressionType::EQUALS, 'pending');
        $this->assertEquals("WHERE status = 'active' OR status = 'pending'", $where->getWhere);
    }

    public function testMixedAndOrConditions(): void
    {
        $where = new WhereClausule();
        $where->and('age', ExpressionType::GREATER_THAN, '18')
            ->or('status', ExpressionType::EQUALS, 'VIP');
        $this->assertEquals("WHERE age > 18 OR status = 'VIP'", $where->getWhere);
    }

    public function testDifferentExpressionTypes(): void
    {
        $where = new WhereClausule();
        $where->and('age', ExpressionType::LESS_THAN, '30')
            ->and('name', ExpressionType::LIKE, '%John%')
            ->and('status', ExpressionType::NOT_EQUALS, 'inactive')
            ->and('points', ExpressionType::GREATER_THAN_OR_EQUALS, '100');
        $this->assertEquals(
            "WHERE age < 30 AND name LIKE '%John%' AND status != 'inactive' AND points >= 100",
            $where->getWhere
        );
    }

    public function testBetweenExpression(): void
    {
        $where = new WhereClausule();
        $where->and('age', ExpressionType::BETWEEN, ['18', '30']);
        $this->assertEquals("WHERE age BETWEEN 18 AND 30", $where->getWhere);
    }

    public function testNotBetweenExpression(): void
    {
        $where = new WhereClausule();
        $where->and('price', ExpressionType::NOT_BETWEEN, ['100', '200']);
        $this->assertEquals("WHERE price NOT BETWEEN 100 AND 200", $where->getWhere);
    }

    public function testInExpression(): void
    {
        $where = new WhereClausule();
        $where->and('status', ExpressionType::IN, ['active', 'pending', 'review']);
        $this->assertEquals("WHERE status IN ('active', 'pending', 'review')", $where->getWhere);
    }

    public function testNotInExpression(): void
    {
        $where = new WhereClausule();
        $where->and('category', ExpressionType::NOT_IN, ['deleted', 'archived']);
        $this->assertEquals("WHERE category NOT IN ('deleted', 'archived')", $where->getWhere);
    }

    public function testIsNullExpression(): void
    {
        $where = new WhereClausule();
        $where->and('deleted_at', ExpressionType::IS_NULL, null);
        $this->assertEquals("WHERE deleted_at IS NULL", $where->getWhere);
    }

    public function testIsNotNullExpression(): void
    {
        $where = new WhereClausule();
        $where->and('email', ExpressionType::IS_NOT_NULL, null);
        $this->assertEquals("WHERE email IS NOT NULL", $where->getWhere);
    }

    public function testLessThanOrEqualsExpression(): void
    {
        $where = new WhereClausule();
        $where->and('quantity', ExpressionType::LESS_THAN_OR_EQUALS, '10');
        $this->assertEquals("WHERE quantity <= 10", $where->getWhere);
    }

    public function testNestedWhereClauses(): void
    {
        $mainWhere = new WhereClausule();

        $firstGroup = new WhereClausule();
        $firstGroup->and('a', ExpressionType::EQUALS, 'b')
            ->or('c', ExpressionType::EQUALS, 'd');

        $secondGroup = new WhereClausule();
        $secondGroup->and('d', ExpressionType::EQUALS, 'e')
            ->and('e', ExpressionType::EQUALS, 'f');

        $mainWhere->add($firstGroup, ExpressionType::AND)
            ->add($secondGroup, ExpressionType::AND);

        $this->assertEquals("WHERE (a = 'b' OR c = 'd') AND (d = 'e' AND e = 'f')", $mainWhere->getWhere);
    }

    public function testComplexNestedWhereClauses(): void
    {
        $mainWhere = new WhereClausule();

        $nestedGroup = new WhereClausule();
        $nestedGroup->and('b', ExpressionType::EQUALS, 'c')
            ->and('d', ExpressionType::EQUALS, 'e');

        $firstGroup = new WhereClausule();
        $firstGroup->and('a', ExpressionType::EQUALS, 'b')
            ->add($nestedGroup, ExpressionType::OR);

        $secondGroup = new WhereClausule();
        $secondGroup->and('f', ExpressionType::EQUALS, 'g');

        $mainWhere->add($firstGroup, ExpressionType::AND)
            ->add($secondGroup, ExpressionType::AND);

        $this->assertEquals("WHERE (a = 'b' OR (b = 'c' AND d = 'e')) AND (f = 'g')", $mainWhere->getWhere);
    }

}

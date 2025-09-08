<?php

namespace Leonardocrcst\Tests;

use Leonardocrcst\QueryBuilder\SelectQueryBuilder;
use Leonardocrcst\QueryBuilder\Types\ExpressionType;
use Leonardocrcst\QueryBuilder\Types\JoinType;
use PHPUnit\Framework\TestCase;

class SelectQueryBuilderTest extends TestCase
{
    public function testBasicSelect(): void
    {
        $builder = new SelectQueryBuilder('users');
        $this->assertEquals('SELECT * FROM users', $this->normalizeString($builder));
    }
    public function testBasicSelectWithColumns(): void
    {
        $builder = new SelectQueryBuilder('users');
        $builder
            ->addColumn('id')
            ->addColumn('name');
        $this->assertEquals('SELECT id, name FROM users', $this->normalizeString($builder));
    }

    public function testSelectWithOrder(): void
    {
        $builder = new SelectQueryBuilder('users');
        $builder->setOrder('name');
        $this->assertEquals('SELECT * FROM users ORDER BY name asc', $this->normalizeString($builder));
    }

    public function testSelectWithLimit(): void
    {
        $builder = new SelectQueryBuilder('users');
        $builder->setLimit(10, 20);
        $this->assertEquals('SELECT * FROM users LIMIT 10 OFFSET 20', $this->normalizeString($builder));
    }

    public function testSelectWithOrderAndLimit(): void
    {
        $builder = new SelectQueryBuilder('users');
        $builder->setOrder('name', 'desc');
        $builder->setLimit(5);
        $this->assertEquals('SELECT * FROM users ORDER BY name desc LIMIT 5', $this->normalizeString($builder));
    }

    public function testSelectWithJoin(): void
    {
        $builder = new SelectQueryBuilder('users');
        $builder->addColumn('name', 'name_alias');
        $join = $builder->setJoin(JoinType::LEFT, 'profile');
        $join->add('id', ExpressionType::EQUALS, 'user_id');
        $this->assertEquals(
            'SELECT name AS name_alias FROM users LEFT JOIN `profile` ON `users`.`id` = `profile`.`user_id`',
            $this->normalizeString($builder)
        );
    }

    private function normalizeString(string $string): string
    {
        return preg_replace('/\s+/', ' ', $string);
    }
}

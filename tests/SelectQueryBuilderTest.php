<?php

namespace Leonardocrcst\Tests;

use Leonardocrcst\QueryBuilder\SelectQueryBuilder;
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
        $builder->columns = ['id', 'name'];
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

    private function normalizeString(string $string): string
    {
        return preg_replace('/\s+/', ' ', $string);
    }
}

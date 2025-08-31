<?php

namespace Leonardocrcst\Tests;

use Leonardocrcst\QueryBuilder\QueryBuilder;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testInsertQueryBuilderWithMultipleRows(): void
    {
        $builder = new QueryBuilder('table');
        $query = $builder->insert([
            [
                'id' => 1,
                'name' => 'test',
            ],
            [
                'id' => 2,
                'name' => 'another test',
            ]
        ]);
        $this->assertEquals("INSERT INTO table (id, name) VALUES ('1', 'test'), ('2', 'another test')", (string) $query);
    }

    public function testDeleteQuery(): void
    {
        $builder = new QueryBuilder('table');
        $query = $builder->delete('id', [1,2,'test']);
        $this->assertEquals('DELETE FROM table WHERE id IN ("1", "2", "test")', (string) $query);
    }

    public function testUpdateQuery(): void
    {
        $builder = new QueryBuilder('table');
        $update = $builder->update();
        $update->value('name', 'test', 'id', 1);
        $update->value('name', 'another test', 'id', 2);

        $this->assertEquals("UPDATE table SET name = CASE id WHEN '1' THEN 'test' WHEN '2' THEN 'another test' ELSE name END WHERE id IN ('1', '2')", (string) $update);
    }

    public function testSelectQuery(): void
    {
        $builder = new QueryBuilder('table');
        $select = $builder->select();
        $this->assertEquals('SELECT * FROM table', (string)$select);
    }

    public function testSelectQueryWithColumns(): void
    {
        $builder = new QueryBuilder('table');
        $select = $builder->select(['id', 'name', 'email', 'created_at']);
        $this->assertEquals('SELECT id, name, email, created_at FROM table', (string)$select);
    }
}

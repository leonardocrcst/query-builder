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
}

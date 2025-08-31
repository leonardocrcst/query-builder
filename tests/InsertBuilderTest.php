<?php

namespace Leonardocrcst\Tests;

use Leonardocrcst\QueryBuilder\InsertQueryBuilder;
use PHPUnit\Framework\TestCase;

class InsertBuilderTest extends TestCase
{
    public function testInsertQueryBuilder(): void
    {
        $insert = new InsertQueryBuilder('table');
        $insert->value('id', 1);
        $insert->value('name', 'test');

        $this->assertEquals("INSERT INTO table (id, name) VALUES (1, 'test')", (string) $insert);
    }

    public function testInsertQueryBuilderWithMultipleRows(): void
    {
        $insert = new InsertQueryBuilder('table');
        $insert->value('id', 1);
        $insert->value('name', 'test');
        $insert->value('id', 2, 1);
        $insert->value('name', 'another test', 1);

        $this->assertEquals("INSERT INTO table (id, name) VALUES (1, 'test'), (2, 'another test')", (string) $insert);
    }
}

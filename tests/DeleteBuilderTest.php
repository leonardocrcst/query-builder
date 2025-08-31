<?php

namespace Leonardocrcst\Tests;

use Leonardocrcst\QueryBuilder\DeleteQueryBuilder;
use PHPUnit\Framework\TestCase;

class DeleteBuilderTest extends TestCase
{
    public function testDeleteQuery(): void
    {
        $builder = new DeleteQueryBuilder('table');
        $builder->value('id', [1,2,'test']);

        $this->assertEquals('DELETE FROM table WHERE id IN ("1", "2", "test")', (string) $builder);
    }
}

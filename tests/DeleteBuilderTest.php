<?php

namespace Tests;

use QueryBuilder\DeleteBuilder;
use PHPUnit\Framework\TestCase;

class DeleteBuilderTest extends TestCase
{
    public function testDeleteQuery(): void
    {
        $builder = new DeleteBuilder('table');
        $builder->value('id', [1,2,'test']);

        $this->assertEquals('DELETE FROM table WHERE id IN ("1", "2", "test")', (string) $builder);
    }
}

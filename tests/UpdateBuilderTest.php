<?php

namespace Tests;

use QueryBuilder\UpdateBuilder;
use PHPUnit\Framework\TestCase;

class UpdateBuilderTest extends TestCase
{
    public function testUpdateBuilder(): void
    {
        $builder = new UpdateBuilder('table');
        $builder->value('name', 'test', 'id', 1);
        $builder->value('name', 'another test', 'id', 2);

        $this->assertEquals("UPDATE table SET name = CASE id WHEN '1' THEN 'test' WHEN '2' THEN 'another test' ELSE name END WHERE id IN ('1', '2')", (string) $builder);
    }

    public function testUpdateBuilderWithMultipleColumns(): void
    {
        $builder = new UpdateBuilder('table');
        $builder->value('name', 'test', 'id', 1);
        $builder->value('value', 1, 'id', 1);
        $builder->value('name', 'another test', 'id', 2);
        $builder->value('value', 2, 'id', 2);

        $this->assertEquals("UPDATE table SET name = CASE id WHEN '1' THEN 'test' WHEN '2' THEN 'another test' ELSE name END, value = CASE id WHEN '1' THEN '1' WHEN '2' THEN '2' ELSE value END WHERE id IN ('1', '2')", (string) $builder);
    }
}

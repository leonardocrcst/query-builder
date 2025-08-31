<?php

namespace Leonardocrcst\Tests\Clausules;

use Leonardocrcst\QueryBuilder\Clausules\LimitClausule;
use PHPUnit\Framework\TestCase;

class LimitTest extends TestCase
{
    private LimitClausule $limit;

    protected function setUp(): void
    {
        $this->limit = new LimitClausule();
    }

    public function testEmptyLimitShouldReturnNull(): void
    {
        $this->assertNull($this->limit->getLimit);
    }

    public function testLimitWithoutOffsetShouldReturnOnlyLimit(): void
    {
        $this->limit->limit = '10';
        $this->assertEquals('LIMIT 10', $this->limit->getLimit);
    }

    public function testLimitWithOffsetShouldReturnLimitAndOffset(): void
    {
        $this->limit->limit = '10';
        $this->limit->offset = '5';
        $this->assertEquals('LIMIT 10 OFFSET 5', $this->limit->getLimit);
    }

    public function testSettingLimitAndOffsetSeparatelyShouldWork(): void
    {
        $this->limit->limit = '20';
        $this->assertEquals('LIMIT 20', $this->limit->getLimit);

        $this->limit->offset = '10';
        $this->assertEquals('LIMIT 20 OFFSET 10', $this->limit->getLimit);
    }

}

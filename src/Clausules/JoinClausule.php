<?php

namespace Leonardocrcst\QueryBuilder\Clausules;

use InvalidArgumentException;
use Leonardocrcst\QueryBuilder\Types\ExpressionType;
use Leonardocrcst\QueryBuilder\Types\JoinType;

class JoinClausule
{
    public array $types = [];
    public array $clausules = [];

    public ?string $getJoin {
        get {
            if (empty($this->clausules)) {
                return null;
            }
            $joins = array_map(function ($clausule, $position) {
                return $position === 0 ? "ON $clausule" : "{$this->types[$position]} $clausule";
            }, array_values($this->clausules), array_keys($this->clausules));
            return sprintf(
                "%s `%s` %s",
                $this->joinType->value,
                $this->joinTable,
                implode(' ', $joins)
            );
        }
    }

    public function __construct(
        protected JoinType $joinType,
        protected string $onTable,
        protected string $joinTable
    ) {
    }

    public function add(
        string $onColumn,
        ExpressionType $expressionType,
        string $joinColumn,
        ExpressionType $type = ExpressionType::AND
    ): self {
        if (!in_array($type, ExpressionType::getAndOrTypes())) {
            throw new InvalidArgumentException("Invalid type ($type->value)", 500);
        }
        $this->types[] = $type->value;
        $this->clausules[] = sprintf(
            "`%s`.`%s` %s `%s`.`%s`",
            $this->onTable,
            $onColumn,
            $expressionType->value,
            $this->joinTable,
            $joinColumn
        );
        return $this;
    }
}

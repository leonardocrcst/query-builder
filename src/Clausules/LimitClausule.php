<?php

namespace Leonardocrcst\QueryBuilder\Clausules;

class LimitClausule
{
    public int $limit {
        set => $this->limit = $value;
    }

    public int $offset {
        set => $this->offset = $value;
    }

    public ?string $getLimit {
        get {
            if (empty($this->limit)) {
                return null;
            }
            return "LIMIT $this->limit" . (!empty($this->offset) ? " OFFSET $this->offset" : '');
        }
    }
}

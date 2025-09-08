<?php

namespace Leonardocrcst\QueryBuilder\Types;

enum JoinType: string
{
    case INNER = 'INNER JOIN';
    case LEFT = 'LEFT JOIN';
    case OUTER = 'OUTER JOIN';
    case RIGHT = 'RIGHT JOIN';
}

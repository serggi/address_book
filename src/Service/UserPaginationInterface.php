<?php

namespace App\Service;

use Knp\Component\Pager\Pagination\PaginationInterface as SlidingPaginationInterface;

interface UserPaginationInterface
{
    const DEFAULT_PAGE  = 1;
    const DEFAULT_LIMIT = 9;

    public function get(): SlidingPaginationInterface;
}

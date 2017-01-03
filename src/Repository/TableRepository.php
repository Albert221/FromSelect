<?php

namespace FromSelect\Repository;

use FromSelect\Pagination;

interface TableRepository
{
    /**
     * Returns an array of paginated rows array, query and execution time of query.
     *
     * @param $database
     * @param $table
     * @param Pagination $pagination
     *
     * @return array [rows, query, executionTime]
     */
    public function paginatedData($database, $table, Pagination $pagination);
}

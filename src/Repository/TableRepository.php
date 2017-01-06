<?php

namespace FromSelect\Repository;

use FromSelect\Pagination;

interface TableRepository
{
    /**
     * Returns an array of paginated rows array, query and execution time
     * of query and sets the count of rows in a pagination object.
     *
     * @param string $database
     * @param string $table
     * @param Pagination $pagination
     *
     * @return array [rows, query, executionTime]
     */
    public function paginatedData($database, $table, Pagination &$pagination);

    /**
     * Returns the number of rows in specified table.
     *
     * @param string $database
     * @param string $table
     * @return int
     */
    public function rowsCount($database, $table);
}

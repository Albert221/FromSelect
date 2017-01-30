<?php

namespace FromSelect\Repository;

use FromSelect\Pagination;
use FromSelect\Entity\Column;

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
    public function data($database, $table, Pagination $pagination);

    /**
     * Returns a Column objects containing all table fields.
     *
     * @param string $database
     * @param string $table
     * @return Column[]
     */
    public function columns($database, $table);

    /**
     * Returns all table indexes.
     *
     * @param string $database
     * @param string $table
     * @return array
     */
    public function indexes($database, $table);
}

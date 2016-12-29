<?php

namespace FromSelect\Repository;

interface DatabaseRepository
{
    /**
     * Returns an associative array of database => table[] pair.
     *
     * @return array
     */
    public function getTree();

    /**
     * Returns an array with: 1. an array of Table objects 2. query 3. execution time.
     *
     * @param $name string Database name
     * @return array
     */
    public function getTablesByDatabase($name);
}

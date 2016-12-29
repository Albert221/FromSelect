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
     * Returns an array of table's objects in the specified database.
     *
     * @param $name string Database name
     * @return array
     */
    public function getTablesByDatabase($name);
}

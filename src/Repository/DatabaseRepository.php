<?php

namespace FromSelect\Repository;

use FromSelect\Repository\Exception\DatabaseNotFoundException;

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
     * @throws DatabaseNotFoundException when database with specified name does not exists.
     */
    public function getTablesInDatabase($name);
}

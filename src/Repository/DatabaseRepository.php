<?php

namespace FromSelect\Repository;

use FromSelect\Entity\Database;

interface DatabaseRepository
{
    /**
     * Returns an associative array of database => table[] pair.
     *
     * @return array
     */
    public function tree();

    /**
     * Returns all databases.
     *
     * @return Database[]
     */
    public function all();

    /**
     * Returns an array with: 1. an array of Table objects 2. query 3. execution time.
     *
     * @param $name string Database name
     * @return array
     */
    public function tablesByDatabase($name);
}

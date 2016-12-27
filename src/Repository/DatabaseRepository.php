<?php

namespace FromSelect\Repository;

interface DatabaseRepository
{
    /**
     * Returns associative array of database => table[] pair.
     *
     * @return array
     */
    public function getTree();
}

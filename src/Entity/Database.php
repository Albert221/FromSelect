<?php

namespace FromSelect\Entity;

class Database
{
    /**
     * @var string Database name.
     */
    private $name;

    /**
     * @var string Character set.
     */
    private $characterSet;

    /**
     * @var string Collation.
     */
    private $collation;

    /**
     * @var Table[]
     */
    private $tables = [];

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCharacterSet()
    {
        return $this->characterSet;
    }

    /**
     * @param string $characterSet
     */
    public function setCharacterSet($characterSet)
    {
        $this->characterSet = $characterSet;
    }

    /**
     * @return string
     */
    public function getCollation()
    {
        return $this->collation;
    }

    /**
     * @param string $collation
     */
    public function setCollation($collation)
    {
        $this->collation = $collation;
    }

    /**
     * @return Table[]
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param Table[] $table
     */
    public function addTable($table)
    {
        $this->tables[] = $table;
    }
}

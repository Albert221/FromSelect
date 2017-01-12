<?php

namespace FromSelect\Entity;

class Database
{
    const MAP = [
        'SCHEMA_NAME' => 'name',
        'DEFAULT_CHARACTER_SET_NAME' => 'characterSet',
        'DEFAULT_COLLATION_NAME' => 'collation'
    ];

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
}

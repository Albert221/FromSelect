<?php

namespace FromSelect\Entity;

class Table
{
    const MAP = [
        'TABLE_NAME' => 'name',
        'TABLE_ROWS' => 'rowCount',
        'TABLE_COLLATION' => 'collation',
        'TABLE_COMMENT' => 'comment'
    ];

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $engine;

    /**
     * @var int
     */
    private $rowCount;

    /**
     * @var string
     */
    private $collation;

    /**
     * @var string
     */
    private $comment;

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
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param string $engine
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    /**
     * @return int
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }

    /**
     * @param int $rowCount
     */
    public function setRowCount($rowCount)
    {
        $this->rowCount = $rowCount;
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
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}

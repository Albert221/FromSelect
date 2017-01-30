<?php

namespace FromSelect\Entity;

class Index
{
    const MAP = [
        'NON_UNIQUE' => 'unique',
        'INDEX_NAME' => 'name',
        'COLLATION' => 'collation',
        'CARDINALITY' => 'cardinality',
        'PACKED' => 'packed',
        'NULLABLE' => 'nullable',
        'INDEX_TYPE' => 'type',
        'COMMENT' => 'comment'
    ];

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $collation;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $nullable;

    /**
     * @var bool
     */
    private $unique;

    /**
     * @var int
     */
    private $cardinality;

    /**
     * @var int
     */
    private $packed;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isNullable()
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     */
    public function setNullable($nullable)
    {
        $this->nullable = $nullable == 'YES';
    }

    /**
     * @return bool
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * @param bool $unique
     */
    public function setUnique($unique)
    {
        $this->unique = $unique == 0;
    }

    /**
     * @return int
     */
    public function getCardinality()
    {
        return $this->cardinality;
    }

    /**
     * @param int $cardinality
     */
    public function setCardinality($cardinality)
    {
        $this->cardinality = (int) $cardinality;
    }

    /**
     * @return int
     */
    public function getPacked()
    {
        return $this->packed;
    }

    /**
     * @param int $packed
     */
    public function setPacked($packed)
    {
        $this->packed = (int) $packed;
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

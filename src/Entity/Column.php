<?php

namespace FromSelect\Entity;

class Column
{
    const MAP = [
        'COLUMN_NAME' => 'name',
        'COLUMN_DEFAULT' => 'default',
        'IS_NULLABLE' => 'nullable',
        'DATA_TYPE' => 'dataType',
        'CHARACTER_MAXIMUM_LENGTH' => 'characterMaxLength',
        'NUMERIC_PRECISION' => 'numericPrecision',
        'NUMERIC_SCALE' =>'numericScale',
        'CHARACTER_SET_NAME' => 'characterSet',
        'COLLATION_NAME' => 'collation',
        'COLUMN_TYPE' => 'columnType',
        'EXTRA' => 'extra',
        'COLUMN_COMMENT' => 'comment'
    ];

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $default;

    /**
     * @var bool
     */
    private $nullable;

    /**
     * @var string
     */
    private $dataType;

    /**
     * @var string
     */
    private $columnType;

    /**
     * @var int
     */
    private $characterMaxLength;

    /**
     * @var int
     */
    private $numericPrecision;

    /**
     * @var int
     */
    private $numericScale;

    /**
     * @var string
     */
    private $characterSet;

    /**
     * @var string
     */
    private $collation;

    /**
     * @var string
     */
    private $extra;

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
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
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
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param string $dataType
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @return string
     */
    public function getColumnType()
    {
        return $this->columnType;
    }

    /**
     * @param string $columnType
     */
    public function setColumnType($columnType)
    {
        $this->columnType = $columnType;
    }


    /**
     * @return int
     */
    public function getCharacterMaxLength()
    {
        return $this->characterMaxLength;
    }

    /**
     * @param int $characterMaxLength
     */
    public function setCharacterMaxLength($characterMaxLength)
    {
        $this->characterMaxLength = $characterMaxLength;
    }

    /**
     * @return int
     */
    public function getNumericPrecision()
    {
        return $this->numericPrecision;
    }

    /**
     * @param int $numericPrecision
     */
    public function setNumericPrecision($numericPrecision)
    {
        $this->numericPrecision = $numericPrecision;
    }

    /**
     * @return int
     */
    public function getNumericScale()
    {
        return $this->numericScale;
    }

    /**
     * @param int $numericScale
     */
    public function setNumericScale($numericScale)
    {
        $this->numericScale = $numericScale;
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
     * @return string
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param string $extra
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;
    }

    /**
     * @return bool
     */
    public function isAutoIncrementable()
    {
        return stripos($this->extra, 'AUTO_INCREMENT') !== false;
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

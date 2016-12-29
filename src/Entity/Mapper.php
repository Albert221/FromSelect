<?php

namespace FromSelect\Entity;

use InvalidArgumentException;
use ReflectionClass;

class Mapper
{
    /**
     * @var string Entity name.
     */
    private $entityName;

    /**
     * Mapper constructor.
     *
     * @param string $entityName Name of the entity's class to map result to.
     */
    public function __construct($entityName)
    {
        if (! class_exists($entityName)) {
            throw new InvalidArgumentException(sprintf(
                'Class %s does not exists.',
                $entityName
            ));
        }

        $this->entityName = $entityName;
    }

    /**
     * Map given array to entity object.
     *
     * @param array $result
     * @param array $map
     */
    public function mapResult(array &$result, array $map = [])
    {
        $reflection = new ReflectionClass($this->entityName);
        $entity = $reflection->newInstance();

        foreach ($result as $field => $value) {
            $setterName = sprintf('set%s', ucfirst($field));

            if (! $reflection->hasMethod($setterName)) {
                $setterName = sprintf('set%s', ucfirst($map[$field]));
                if (! $reflection->hasMethod($setterName)) {
                    continue;
                }
            }

            $entity->{$setterName}($value);
        }

        $result = $entity;
    }

    /**
     * Maps array of results
     *
     * @param array $results
     * @param array $map
     */
    public function mapResults(array &$results, array $map = [])
    {
        foreach ($results as &$result) {
            $this->mapResult($result, $map);
        }
    }
}

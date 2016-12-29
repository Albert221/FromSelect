<?php

namespace FromSelect\Repository;

use FromSelect\Entity\Mapper;
use FromSelect\Entity\Table;
use FromSelect\PDO;

class MySQLDatabaseRepository implements DatabaseRepository
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var Mapper
     */
    private $tableMapper;

    /**
     * PDODatabaseRepository constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->tableMapper = new Mapper(Table::class);
    }

    /**
     * Returns an associative array of database => table[] pair.
     *
     * @return array
     */
    public function getTree()
    {
        $result = $this->pdo->query('
            SELECT
              `dbs`.`SCHEMA_NAME` AS `database`,
              `tables`.`TABLE_NAME` AS `table`
            FROM
              `information_schema`.`SCHEMATA` AS `dbs`
            LEFT JOIN
              `information_schema`.`TABLES` AS `tables`
                ON `dbs`.`SCHEMA_NAME` = `tables`.`TABLE_SCHEMA`
        ')->fetchAll();

        $tree = [];

        foreach ($result as $item) {
            $tree[$item['database']][] = $item['table'];
        }

        return $tree;
    }


    /**
     * Returns an array of table's objects in the specified database.
     *
     * @param $name string Database name
     * @return Table[]
     */
    public function getTablesByDatabase($name)
    {
        $start = microtime(true);

        $statement = $this->pdo->prepare('
            SELECT
              `TABLE_NAME`,
              `ENGINE`,
              `TABLE_ROWS`,
              `TABLE_COLLATION`,
              `TABLE_COMMENT`
            FROM
              `information_schema`.`TABLES`
            WHERE
              `TABLE_SCHEMA` = :database
        ');

        $statement->bindValue(':database', $name);
        $statement->execute();

        $executionTime = microtime(true) - $start;

        $results = $statement->fetchAll();

        $this->tableMapper->mapResults($results, Table::MAP);

        return [$results, $statement->queryString, $executionTime];
    }
}

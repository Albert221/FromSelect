<?php

namespace FromSelect\Repository;

use FromSelect\Entity\Database;
use FromSelect\Entity\Mapper;
use FromSelect\Entity\Table;
use FromSelect\PDO\PDO;

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
     * @var Mapper
     */
    private $databaseMapper;

    /**
     * PDODatabaseRepository constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->tableMapper = new Mapper(Table::class);
        $this->databaseMapper = new Mapper(Database::class);
    }

    /**
     * Returns an associative array of database => table[] pair.
     *
     * @return array
     */
    public function tree()
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
     * Returns all databases.
     *
     * @return Database[]
     */
    public function all()
    {
        $results = $this->pdo->query('
            SELECT
              `SCHEMA_NAME`,
              `DEFAULT_CHARACTER_SET_NAME`,
              `DEFAULT_COLLATION_NAME`
            FROM
              `information_schema`.`SCHEMATA`
        ')->fetchAll();

        $this->databaseMapper->mapResults($results, Database::MAP);

        return $results;
    }


    /**
     * Returns an array of table's objects in the specified database.
     *
     * @param $name string Database name
     * @return Table[]
     */
    public function tablesByDatabase($name)
    {
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

        $results = $statement->fetchAll();

        $this->tableMapper->mapResults($results, Table::MAP);

        return $results;
    }
}

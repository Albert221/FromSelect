<?php

namespace FromSelect\Repository;

use FromSelect\Entity\Index;
use FromSelect\Entity\Mapper;
use FromSelect\Entity\Column;
use FromSelect\Pagination;
use FromSelect\PDO\PDO;

class MySQLTableRepository implements TableRepository
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var Mapper
     */
    private $columnMapper;

    /**
     * @var Mapper
     */
    private $indexMapper;

    /**
     * MySQLTableRepository constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->columnMapper = new Mapper(Column::class);
        $this->indexMapper = new Mapper(Index::class);
    }

    /**
     * Returns an array of paginated rows array, query and execution time
     * of query and sets the count of rows in a pagination object.
     *
     * @param $database
     * @param $table
     * @param Pagination $pagination
     *
     * @return array [rows, query, executionTime]
     */
    public function data($database, $table, Pagination $pagination)
    {
        $start = microtime(true);

        $statement = $this->pdo->prepare(sprintf(
            'SELECT * FROM `%s`.`%s` %s LIMIT :start, :perPage',
            $database,
            $table,
            $pagination->getSortField() !== '' ?
                sprintf(
                    'ORDER BY `%s` %s',
                    $pagination->getSortField(),
                    $pagination->getSortOrder() === Pagination::SORT_ASC ?
                        'ASC' : 'DESC'
                ) : ''
        ));

        $statement->bindValue(':start', $pagination->getFirstRow(), PDO::PARAM_INT);
        $statement->bindValue(':perPage', $pagination->getPerPage(), PDO::PARAM_INT);
        $statement->execute();

        $executionTime = microtime(true) - $start;
        $results = $statement->fetchAll();

        $pagination->setCount($this->rowsCount($database, $table));

        return [
            $results,
            str_replace(
                [':start', ':perPage'],
                [$pagination->getFirstRow(), $pagination->getPerPage()],
                $statement->queryString
            ),
            $executionTime,
        ];
    }

    /**
     * Returns the number of rows in specified table.
     *
     * @param string $database
     * @param string $table
     * @return int
     */
    private function rowsCount($database, $table)
    {
        $statement = $this->pdo->prepare('
          SELECT
            `TABLE_ROWS`
          FROM
            `information_schema`.`TABLES`
          WHERE
            `TABLE_SCHEMA` = :database
            AND `TABLE_NAME` = :table
        ');

        $statement->bindValue(':database', $database);
        $statement->bindValue(':table', $table);
        $statement->execute();

        return (int) $statement->fetchColumn();
    }

    /**
     * Returns a TableStructureField object containing all table fields.
     *
     * @param string $database
     * @param string $table
     * @return Column[]
     */
    public function columns($database, $table)
    {
        $statement = $this->pdo->prepare('
            SELECT
              `COLUMN_NAME`,
              `COLUMN_DEFAULT`,
              `IS_NULLABLE`,
              `DATA_TYPE`,
              `CHARACTER_MAXIMUM_LENGTH`,
              `NUMERIC_PRECISION`,
              `NUMERIC_SCALE`,
              `CHARACTER_SET_NAME`,
              `COLLATION_NAME`,
              `COLUMN_TYPE`,
              `EXTRA`,
              `COLUMN_COMMENT`
            FROM
              `information_schema`.`COLUMNS`
            WHERE
              `TABLE_SCHEMA` = :database
              AND `TABLE_NAME` = :table
            ORDER BY
              `ORDINAL_POSITION`
        ');

        $statement->bindValue(':database', $database);
        $statement->bindValue(':table', $table);
        $statement->execute();

        $results = $statement->fetchAll();

        $this->columnMapper->mapResults($results, Column::MAP);

        return $results;
    }

    /**
     * Returns all table indexes.
     *
     * @param string $database
     * @param string $table
     * @return array
     */
    public function indexes($database, $table)
    {
        $statement = $this->pdo->prepare('
            SELECT
              `NON_UNIQUE`,
              `INDEX_NAME`,
              `COLUMN_NAME`,
              `COLLATION`,
              `CARDINALITY`,
              `PACKED`,
              `NULLABLE`,
              `INDEX_TYPE`,
              `COMMENT`
            FROM
              `information_schema`.`STATISTICS`
            WHERE
              `TABLE_SCHEMA` = :database
              AND `TABLE_NAME` = :table
        ');

        $statement->bindValue(':database', $database);
        $statement->bindValue(':table', $table);
        $statement->execute();

        $results = $statement->fetchAll();

        $this->indexMapper->mapResults($results, Index::MAP);

        return $results;
    }
}

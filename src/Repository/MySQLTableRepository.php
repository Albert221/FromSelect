<?php

namespace FromSelect\Repository;

use FromSelect\Pagination;
use FromSelect\PDO\PDO;

class MySQLTableRepository implements TableRepository
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * MySQLTableRepository constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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
    public function paginatedData($database, $table, Pagination &$pagination)
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
    public function rowsCount($database, $table)
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
}

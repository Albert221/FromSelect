<?php

namespace FromSelect\Repository;

use FromSelect\Pagination;
use FromSelect\PDO;

class MySQLTableRepository implements TableRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Returns an array of paginated rows array, query and execution time of query.
     *
     * @param $database
     * @param $table
     * @param Pagination $pagination
     *
     * @return array [rows, query, executionTime]
     */
    public function paginatedData($database, $table, Pagination $pagination)
    {
        $start = microtime(true);

        $statement = $this->pdo->prepare(sprintf(
            'SELECT * FROM `%s`.`%s` LIMIT :start, :perPage',
            $database,
            $table
        ));

        $statement->bindValue(':start', $pagination->getFirstRow(), PDO::PARAM_INT);
        $statement->bindValue(':perPage', $pagination->getPerPage(), PDO::PARAM_INT);
        $statement->execute();

        $results = $statement->fetchAll();

        return [
            $results,
            $statement->queryString,
            microtime(true) - $start,
        ];
    }
}

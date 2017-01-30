<?php

namespace FromSelect\Controller;

use FromSelect\Entity\Column;
use FromSelect\Pagination;
use FromSelect\Repository\TableRepository;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class TableController extends AbstractController
{
    /**
     * @var TableRepository
     */
    private $tableRepository;

    /**
     * TableController constructor.
     *
     * @param TableRepository $tableRepository
     */
    public function __construct(TableRepository $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    /**
     * tables.show: GET /db/{database}/{table}
     *
     * @param Request $request
     * @param Response $response
     *
     * @return ResponseInterface
     */
    public function show(Request $request, Response $response)
    {
        $database = $request->getAttribute('database');
        $table = $request->getAttribute('table');

        $pagination = Pagination::createFromRequest($request);

        list($data, $query, $executionTime) = $this->tableRepository->data($database, $table, $pagination);

        if (count($data) === 0) {
            $columns = $this->tableRepository->columns($database, $table);
            array_walk($columns, function (Column &$column) {
                $column = $column->getName();
            });
        }

        return $this->twig->render($response, '@fromselect/tables/show.twig', [
            'data' => $data,
            'columns' => isset($columns) ? $columns : null,
            'current' => [
                'database' => $database,
                'table' => $table,
            ],
            'query' => [
                'query' => $query,
                'executionTime' => $executionTime,
            ],
            'pagination' => $pagination,
        ]);
    }

    /**
     * tables.structure: GET /db/{database}/{table}/structure
     *
     * @param Request $request
     * @param Response $response
     *
     * @return ResponseInterface
     */
    public function structure(Request $request, Response $response)
    {
        $database = $request->getAttribute('database');
        $table = $request->getAttribute('table');

        $columns = $this->tableRepository->columns($database, $table);
        $indexes = $this->tableRepository->indexes($database, $table);

        return $this->twig->render($response, '@fromselect/tables/structure.twig', [
            'columns' => $columns,
            'indexes' => $indexes,
            'current' => [
                'database' => $database,
                'table' => $table
            ]
        ]);
    }
}

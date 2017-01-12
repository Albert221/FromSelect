<?php

namespace FromSelect\Controller;

use FromSelect\Pagination;
use FromSelect\Repository\TableRepository;
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
     * tables.show: GET /{database}/{table}
     *
     * @param Request $request
     * @param Response $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response)
    {
        $database = $request->getAttribute('database');
        $table = $request->getAttribute('table');

        $pagination = Pagination::createFromRequest($request);

        list($data, $query, $executionTime) = $this->tableRepository->paginatedData($database, $table, $pagination);

        return $this->twig->render($response, '@fromselect/tables/show.twig', [
            'data' => $data,
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
}

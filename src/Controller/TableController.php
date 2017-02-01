<?php

namespace FromSelect\Controller;

use FromSelect\Breadcrumbs\Breadcrumb;
use FromSelect\Breadcrumbs\BreadcrumbsStack;
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
     * @var BreadcrumbsStack
     */
    private $breadcrumbs;

    /**
     * TableController constructor.
     *
     * @param TableRepository $tableRepository
     */
    public function __construct(TableRepository $tableRepository)
    {
        $this->tableRepository = $tableRepository;
        $this->breadcrumbs = new BreadcrumbsStack();
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

        $this->fillCrumbs($database, $table);

        $pagination = Pagination::createFromRequest($request);
        list($data, $query, $executionTime) = $this->tableRepository->data($database, $table, $pagination);

        // If no data is retrieved then pass columns to view for the table headings.
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
            'breadcrumbs' => $this->breadcrumbs
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

        $this->fillCrumbs($database, $table);
        $this->breadcrumbs->push(new Breadcrumb('Structure', $this->router->pathFor('tables.structure',
            ['database' => $database, 'table' => $table])));

        $columns = $this->tableRepository->columns($database, $table);
        $indexes = $this->tableRepository->indexes($database, $table);

        return $this->twig->render($response, '@fromselect/tables/structure.twig', [
            'columns' => $columns,
            'indexes' => $indexes,
            'current' => [
                'database' => $database,
                'table' => $table
            ],
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Fills breadcrumbs with given database and table crumb.
     *
     * @param string $database
     * @param string $table
     */
    private function fillCrumbs($database, $table)
    {
        // FIXME: Hardcoded host
        $this->breadcrumbs->push(
            new Breadcrumb('Host: localhost', $this->router->pathFor('databases.all')),
            new Breadcrumb("Database: $database", $this->router->pathFor('databases.show', ['database' => $database])),
            new Breadcrumb("Table: $table", $this->router->pathFor('tables.show', ['database' => $database, 'table' => $table]))
        );
    }
}

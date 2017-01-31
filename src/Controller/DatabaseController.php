<?php

namespace FromSelect\Controller;

use FromSelect\Breadcrumbs\Breadcrumb;
use FromSelect\Breadcrumbs\BreadcrumbsStack;
use FromSelect\Repository\DatabaseRepository;
use Slim\Http\Request;
use Slim\Http\Response;

class DatabaseController extends AbstractController
{
    /**
     * @var DatabaseRepository
     */
    private $databaseRepository;

    /**
     * @var BreadcrumbsStack
     */
    private $breadcrumbs;

    /**
     * DatabaseController constructor, sets database tree as Twig global
     * variable because it is being used on all views.
     *
     * @param DatabaseRepository $databaseRepository
     */
    public function __construct(DatabaseRepository $databaseRepository)
    {
        $this->databaseRepository = $databaseRepository;
        $this->breadcrumbs = new BreadcrumbsStack();
    }

    /**
     * databases.all: GET /
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function all(Request $request, Response $response)
    {
        $this->fillCrumbs();

        $databases = $this->databaseRepository->all();

        return $this->twig->render($response, '@fromselect/databases/all.twig', [
            'databases' => $databases,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * databases.show: GET /db/{database}
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response)
    {
        $database = $request->getAttribute('database');

        $this->fillCrumbs();
        $this->breadcrumbs->push(new Breadcrumb("Database: $database", $this->router->pathFor('databases.show',
            ['database' => $database])));

        $tables = $this->databaseRepository->tablesByDatabase($database);

        return $this->twig->render($response, '@fromselect/databases/show.twig', [
            'tables' => $tables,
            'current' => [
                'database' => $database
            ],
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Fills breadcrumbs with host crumb.
     */
    private function fillCrumbs()
    {
        // FIXME: Hardcoded host
        $this->breadcrumbs->push(
            new Breadcrumb('Host: localhost', $this->router->pathFor('databases.all'))
        );
    }
}

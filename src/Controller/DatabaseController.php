<?php

namespace FromSelect\Controller;

use FromSelect\Repository\DatabaseRepository;
use FromSelect\Repository\Exception\DatabaseNotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class DatabaseController extends AbstractController
{
    /**
     * @var DatabaseRepository
     */
    private $databaseRepository;

    /**
     * DatabaseController constructor, sets database tree as Twig global
     * variable because it is being used on all views.
     *
     * @param DatabaseRepository $databaseRepository
     */
    public function __construct(DatabaseRepository $databaseRepository)
    {
        $this->databaseRepository = $databaseRepository;
    }

    protected function postConstructor()
    {
        $this->twig->getEnvironment()->addGlobal('databaseTree',
            $this->databaseRepository->getTree());
    }

    /**
     * database.show: GET /database/{database}
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response)
    {
        $database = $request->getAttribute('database');

        try {
            $tables = $this->databaseRepository->getTablesByDatabase($database);
        } catch (DatabaseNotFoundException $e) {
            return $response->withStatus(404);
        }

        return $this->twig->render($response, '@fromselect/database.twig', [
            'current' => [
                'database' => $database
            ],
            'tables' => $tables
        ]);
    }
}

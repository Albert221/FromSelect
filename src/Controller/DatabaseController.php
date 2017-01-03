<?php

namespace FromSelect\Controller;

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
     * DatabaseController constructor, sets database tree as Twig global
     * variable because it is being used on all views.
     *
     * @param DatabaseRepository $databaseRepository
     */
    public function __construct(DatabaseRepository $databaseRepository)
    {
        $this->databaseRepository = $databaseRepository;
    }

    /**
     * database.show: GET /{database}
     *
     * @param Request $request
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response)
    {
        $database = $request->getAttribute('database');

        $tables = $this->databaseRepository->getTablesByDatabase($database);

        return $this->twig->render($response, '@fromselect/database.twig', [
            'tables' => $tables,
            'current' => [
                'database' => $database
            ],
        ]);
    }
}

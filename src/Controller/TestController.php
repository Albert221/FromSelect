<?php

namespace FromSelect\Controller;

use FromSelect\Repository\DatabaseRepository;
use Slim\Http\Request;
use Slim\Http\Response;

class TestController extends AbstractController
{
    /**
     * @var DatabaseRepository
     */
    private $databaseRepository;

    /**
     * TestController constructor.
     *
     * @param DatabaseRepository $databaseRepository
     */
    public function __construct(DatabaseRepository $databaseRepository)
    {
        $this->databaseRepository = $databaseRepository;
    }

    public function __invoke(Request $request, Response $response)
    {
        $databases = $this->databaseRepository->getTree();

        return $this->twig->render($response, '@fromselect/results.twig', [
            'databaseTree' => $databases,
            'current' => [
                'database' => null,
                'table' => null
            ]
        ]);
    }
}

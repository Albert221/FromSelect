<?php

namespace FromSelect\Controller;

use FromSelect\PDO\MySQLCredentialsValidator;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ConnectionController extends AbstractController
{
    /**
     * connection.connect: GET /connect
     *
     * @param Request $request
     * @param Response $response
     *
     * @return ResponseInterface
     */
    public function connect(Request $request, Response $response)
    {
        return $this->twig->render($response, '@fromselect/login.twig', [
            'error' => $request->getQueryParam('error')
        ]);
    }

    /**
     * connection.auth: POST /connect
     *
     * @param Request $request
     * @param Response $response
     *
     * @return ResponseInterface
     */
    public function auth(Request $request, Response $response)
    {
        $host = $request->getParsedBodyParam('host');
        $port = $request->getParsedBodyParam('port');
        $username = $request->getParsedBodyParam('username');
        $password = $request->getParsedBodyParam('password');

        $validator = new MySQLCredentialsValidator($host, $port, $username, $password);

        if (!$validator->validate()) {
            return $response->withStatus(302)->withHeader(
                'Location',
                $this->router->pathFor('connection.connect', [], [
                    'error' => 'Wrong credentials :('
                ])
            );
        }

        $_SESSION['connection']['host'] = $host;
        $_SESSION['connection']['port'] = $port;
        $_SESSION['connection']['username'] = $username;
        $_SESSION['connection']['password'] = $password;

        return $response->withStatus(302)->withHeader(
            'Location',
            $this->router->pathFor('databases.all')
        );
    }

    /**
     * connection.disconnect: GET /disconnect
     *
     * @param Request $request
     * @param Response $response
     *
     * @return ResponseInterface
     */
    public function disconnect(Request $request, Response $response)
    {
        unset($_SESSION['connection']);

        return $response->withStatus(302)->withHeader(
            'Location',
            $this->router->pathFor('databases.all')
        );
    }
}

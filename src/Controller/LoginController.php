<?php

namespace FromSelect\Controller;

use FromSelect\PDO\MySQLCredentialsValidator;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginController extends AbstractController
{
    /**
     * login.login: GET /login
     *
     * @param Request $request
     * @param Response $response
     *
     * @return ResponseInterface
     */
    public function login(Request $request, Response $response)
    {
        return $this->twig->render($response, '@fromselect/login.twig', [
            'error' => $request->getQueryParam('error')
        ]);
    }

    /**
     * login.auth: POST /login
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
                $this->router->pathFor('login.login', [], [
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
     * login.logout: GET /logout
     *
     * @param Request $request
     * @param Response $response
     *
     * @return ResponseInterface
     */
    public function logout(Request $request, Response $response)
    {
        unset($_SESSION['connection']);

        return $response->withStatus(302)->withHeader(
            'Location',
            $this->router->pathFor('databases.all')
        );
    }
}

<?php

namespace FromSelect\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class LoginController extends AbstractController
{
    public function login(Request $request, Response $response)
    {
        $this->twig->render($response, '@fromselect/login.twig');
    }

    public function auth(Request $request, Response $response)
    {
        // TODO
    }
}

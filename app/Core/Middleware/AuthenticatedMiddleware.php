<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 15/06/2017
 * Time: 12:18
 */

namespace CyberWorks\Core\Middleware;


class AuthenticatedMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (!$this->container->auth->isAuthed()) {
            $this->container->alerts->addMessage("error", "Please Login before trying to perform that action");
            return $response->withRedirect($this->container->router->pathFor('auth.login'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
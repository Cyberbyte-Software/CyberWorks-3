<?php

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
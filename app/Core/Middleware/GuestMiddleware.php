<?php

namespace CyberWorks\Core\Middleware;


class GuestMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if ($this->container->auth->isAuthed()) {
            return $response->withRedirect($this->container->router->pathFor('dashboard'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
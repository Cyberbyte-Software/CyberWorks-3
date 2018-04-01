<?php

namespace CyberWorks\Core\Middleware\Permissions\API;


use CyberWorks\Core\Middleware\Middleware;

class HasPermissionAPIMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $perms = $this->container->auth->permissions();
        if (!$perms[$this->neededPerm]) {
            return $response->withJson(['error' => 'Failed Permission Check!'], 401);
        }

        $response = $next($request, $response);
        return $response;
    }
}
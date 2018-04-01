<?php

namespace CyberWorks\Core\Middleware\Permissions;

use CyberWorks\Core\Middleware\Middleware;

class HasPermissionMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $perms = $this->container->auth->permissions();
        if (!$perms[$this->neededPerm]) {
            $this->container->alerts->addMessage("error", "You Do Not Have Permission To View This Page");
            return $response->withRedirect($this->container->router->pathFor('dashboard'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
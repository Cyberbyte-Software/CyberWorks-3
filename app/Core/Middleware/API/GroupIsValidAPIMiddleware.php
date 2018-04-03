<?php

namespace CyberWorks\Core\Middleware\API;

use CyberWorks\Core\Models\Group;
use CyberWorks\Core\Middleware\Middleware;

class GroupIsValidAPIMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $group = Group::find($request->getParam('id'));

        if (!$group) {
            return $response->withJson(['error' => 'Group Not Found!'], 404);
        }

        $response = $next($request, $response);
        return $response;
    }
}
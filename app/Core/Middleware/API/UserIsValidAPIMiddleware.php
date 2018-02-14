<?php

namespace CyberWorks\Core\Middleware\API;

use CyberWorks\Core\Models\User;

class UserIsValidAPIMiddleware
{
    public function __invoke($request, $response, $next)
    {
        $user = User::find($request->getParam('id'));

        if (!$user) {
            return $response->withJson(['error' => 'User Not Found!'], 404);
        }

        $response = $next($request, $response);
        return $response;
    }

}
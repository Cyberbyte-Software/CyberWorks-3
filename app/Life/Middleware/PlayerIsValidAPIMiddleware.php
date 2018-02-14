<?php

namespace CyberWorks\Life\Middleware;

use CyberWorks\Life\Models\Player;

class PlayerIsValidAPIMiddleware
{
    public function __invoke($request, $response, $next)
    {
        $args = $request->getAttribute('routeInfo')[2];

        $player = Player::find($args['id']);

        if (!$player) {
            return $response->withJson(['error' => 'Player Not Found!'], 404);
        }

        $response = $next($request, $response);
        return $response;
    }

}
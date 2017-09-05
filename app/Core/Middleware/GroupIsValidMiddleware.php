<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 29/06/2017
 * Time: 15:59
 */

namespace CyberWorks\Core\Middleware;

use CyberWorks\Core\Models\Group;

class GroupIsValidMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $args = $request->getAttribute('routeInfo')[2];
        $user = Group::find($args['id']);

        if (!$user) {
            $this->container->alerts->addMessage("error", "Group Not Found");
            return $response->withRedirect($this->container->router->pathFor('dashboard'));
        }

        $response = $next($request, $response);
        return $response;
    }

}
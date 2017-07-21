<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 13:48
 */

namespace CyberWorks\Core\Middleware;


class OldInputMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (isset($_SESSION['old'])) {
            $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
            $_SESSION['old'] = $request->getParams();
        }

        $response = $next($request, $response);
        return $response;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 12:10
 */

namespace CyberWorks\Core\Middleware;

class ValidationErrorsMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (isset($_SESSION['errors'])) {
            $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
            unset($_SESSION['errors']);
        }

        $response = $next($request, $response);
        return $response;
    }
}
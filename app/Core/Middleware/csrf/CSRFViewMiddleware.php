<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 14:49
 */

namespace CyberWorks\Core\Middleware\csrf;

use CyberWorks\Core\Middleware\Middleware;

class CSRFViewMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $this->container->view->getEnvironment()->addGlobal('csrf', [
            'field' => '
                <input type="hidden" name="'. $this->container->csrf->getTokenNameKey() .'" value="'. $this->container->csrf->getTokenName() .'">
                <input type="hidden" name="'. $this->container->csrf->getTokenValueKey() .'" value="'. $this->container->csrf->getTokenValue() .'">                
            ',
            'javascript' => [
                'tokenNameKey' => $this->container->csrf->getTokenNameKey(),
                'tokenName' => $this->container->csrf->getTokenName(),
                'tokenValueKey' => $this->container->csrf->getTokenValueKey(),
                'tokenValue' => $this->container->csrf->getTokenValue(),
            ],
        ]);
        $response = $next($request, $response);
        return $response;
    }
}
<?php

namespace CyberWorks\Core\Middleware\csrf;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CyberWorks\Core\Middleware\Middleware;

class CSRFHeaderMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $nameKey = $this->container->csrf->getTokenNameKey();
        $valueKey = $this->container->csrf->getTokenValueKey();

        $csrfToken = [
            $nameKey  => $this->container->csrf->getTokenName(),
            $valueKey => $this->container->csrf->getTokenValue()
        ];

        if ($csrfToken[$nameKey] && $csrfToken[$valueKey]) {
            $response = $response->withHeader('X-CSRF-Token', json_encode($csrfToken));
        }

        return $next($request, $response);
    }
}
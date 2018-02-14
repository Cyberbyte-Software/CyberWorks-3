<?php

namespace CyberWorks\Core\Middleware;


class Middleware
{
    protected $container;
    protected $neededPerm;

    public function __construct($container, $neededPerm = "")
    {
        $this->container = $container;
        $this->neededPerm = $neededPerm;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 12:09
 */

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
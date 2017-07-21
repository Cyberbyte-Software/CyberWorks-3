<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 09:29
 */

namespace CyberWorks\Core\Controllers;

use Interop\Container\ContainerInterface;

class Controller
{
    protected $conainter;

    public function __construct(ContainerInterface $container)
    {
        $this->conainter = $container;
    }

    public function __get($property)
    {
        if ($this->conainter->{$property}) return $this->conainter->{$property};
    }
}
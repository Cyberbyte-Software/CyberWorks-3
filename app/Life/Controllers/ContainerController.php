<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 03/08/2017
 * Time: 15:42
 */

namespace CyberWorks\Life\Controllers;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Life\Models\Container;
use LiveControl\EloquentDataTable\DataTable;

class ContainerController extends Controller
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'life/containers.twig');
    }

    public function table($request, $response)
    {
        $containers = new Container();
        $table = new DataTable($containers, ['id', 'classname', 'pos', 'inventory', 'gear', 'dir']);

        $table->setFormatRowFunction(function ($container) {
            return [
                '<a href="player/' . $container->owner_id . '"target="_blank">' . $container->owner_name . '</a>',
                $container->classname,
                $container->pos,
                $container->dir,
                '<a onclick=\'showEditContainerBox(' . $container->id . ',' . $container->classname . ',"' . str_replace('"', '\"', $container->gear) . '",'. ',"' . str_replace('"', '\"', $container->inventory) . '",' . $container->dir . ',"' . $container->pos .'")\'><i class="fa fa-pencil"></i></a>',
            ];
        });

        return $response->withJson($table->make());
    }
}
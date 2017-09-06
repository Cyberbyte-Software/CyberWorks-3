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
use CyberWorks\Life\Helper\LifeEditLogger;
use LiveControl\EloquentDataTable\DataTable;
use Respect\Validation\Validator as v;

class ContainerController extends Controller
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'life/containers.twig');
    }

    public function table($request, $response)
    {
        $containers = new Container();
        $table = new DataTable($containers, ['id', 'classname', 'pid', 'pos', 'inventory', 'gear', 'dir']);

        $table->setFormatRowFunction(function ($container) {
            return [
                '<a href="player/' . $container->owner_id . '"target="_blank">' . $container->owner . '</a>',
                $container->classname,
                $container->pos,
                $container->dir,
                '<a onclick=\'showEditContainerBox(' . $container->id . ',"' . $container->classname . '","' . $container->pid . '","' . str_replace('"', '\"', $container->gear) . '","' . str_replace('"', '\"', $container->inventory) . '","' . $container->dir . '","' . $container->pos .'")\'><i class="fa fa-pencil"></i></a>',
            ];
        });

        return $response->withJson($table->make());
    }

    public function updateContainer($request, $response)
    {
        $req_validation = $this->validator->validate($request, [
            'id' => v::notEmpty(),
            'class' => v::notEmpty(),
            'gear' => v::notEmpty(),
            'inv' => v::notEmpty(),
            'dir' => v::notEmpty(),
            'pos' => v::notEmpty(),
            'owner' => v::notEmpty()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors() ], 400);
        }

        $container = Container::find($request->getParam('id'));

        if (!$container) {
            return $response->withJson(['error' => 'Container Not Found'], 404);
        }

        LifeEditLogger::logEdit($request->getParam('id'), 3, "Edited Container: Class Before: ". $container->classname ." After: ".$request->getParam('class')." Pos Before: ". $container->pos ." After: ".$request->getParam('pos')." Dir Before: ". $container->dir ." After: ".$request->getParam('dir')." Inv Before: ". $container->inventory ." After: ".$request->getParam('inv')." Gear Before: ". $container->gear ." After: ".$request->getParam('gear')." Owner Before: ". $container->pid ." After: ".$request->getParam('owner'));

        if ($container->classname != $request->getParam('class')) $container->classname = $request->getParam('class');
        if ($container->pos != $request->getParam('pos')) $container->pos = $request->getParam('pos');
        if ($container->inventory != $request->getParam('inv')) $container->inventory = $request->getParam('inv');
        if ($container->gear != $request->getParam('gear')) $container->gear = $request->getParam('gear');
        if ($container->dir != $request->getParam('dir')) $container->dir = $request->getParam('dir');
        if ($container->pid != $request->getParam('owner')) $container->pid = $request->getParam('owner');

        if ($container->isDirty()) $container->save();

        return $response->withStatus(200);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Maurice Moss
 * Date: 04/09/2017
 * Time: 21:36
 */

namespace CyberWorks\Core\Controllers\Auth;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Core\Models\Group;
use LiveControl\EloquentDataTable\DataTable;

class GroupController extends Controller
{
    public function index($request, $response) {
        return $this->view->render($response, 'groups/index.twig');
    }

    public function table($request, $response) {
        $groups = new Group();
        $table = new DataTable($groups, ['group_id', 'group_name', 'is_superUser']);

        $table->setFormatRowFunction(function ($group) {
            return [
                '<a href="group/' . $group->group_id . '"target="_blank">' . $group->group_name . '</a>',
                ($group->is_superUser == 1 ? "Yes" : "No"),
                '<a href="group/' . $group->group_id . '"target="_blank"><i class="fa fa-pencil"></i></a>'
            ];
        });

        return $response->withJson($table->make());
    }

    public function group($request, $response, $args) {
        $group = Group::find($args['id']);

        if (!$group) {
            $this->alerts->addMessage("error", "Group Not Found");
            return $response->withRedirect($this->router->pathFor('dashboard'));
        }

        $data = ['group' => $group, 'useIps' => $this->container->config->get('useIps', false)];
        return $this->view->render($response, 'groups/group.twig', $data);
    }

    public function updateGroup($request, $response, $args) {
        $group = Group::find($args['id']);

        if (!$group) {
            $this->alerts->addMessage("error", "Group Not Found");
            return $response->withRedirect($this->router->pathFor('dashboard'));
        }

        if ($group->group_name != $request->getParam('group_name')) $group->group_name = $request->getParam('group_name');
        if ($this->container->config->get('useIps', false)) {
            if ($group->group_id != $request->getParam('group_id')) $group->group_id = $request->getParam('group_id');
        }

        if ($group->isDirty()) {
            $this->container->logger->info("Group: " + $group->id + " Was updated By User:" + $_SESSION['user_id']);
            $group->save();
        }
    }
}
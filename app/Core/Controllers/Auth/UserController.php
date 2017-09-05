<?php
/**
 * Created by PhpStorm.
 * User: Maurice Moss
 * Date: 05/09/2017
 * Time: 11:02
 */

namespace CyberWorks\Core\Controllers\Auth;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Core\Models\Group;
use CyberWorks\Core\Models\User;
use LiveControl\EloquentDataTable\DataTable;
use Respect\Validation\Validator as v;

class UserController extends Controller
{
    public function index($request, $response) {

        $groups = Group::all();
        $data = ['groups' => $groups];
        return $this->view->render($response, 'users/index.twig', $data);
    }

    public function new($request, $response) {
        return $this->view->render($response, 'users/new.twig');
    }

    public function table($request, $response) {
        $users = new User();
        $table = new DataTable($users, ['id', 'name', 'email', 'primaryGroup']);



        $table->setFormatRowFunction(function ($user) {
            $pri_group = json_decode($user->primaryGroup);
            $group = Group::find($pri_group->id);

            return [
                $user->name,
                $user->email,
                '<a href="group/' . $group->id . '"target="_blank">' . $group->group_name . '</a>',
                '<a onclick=\'showUserEditBox('. $user->id .',"'. $user->name .'","'. $user->email .'",'. $group->id .')\'><i class="fa fa-pencil"></i></a> <a onclick=\'showUserEditPasswordBox('. $user->id .',"'. $user->name .'")\'><i class="fa fa-key"></i></a>'
            ];
        });

        return $response->withJson($table->make());
    }

    public function updateUser($request, $response) {
        $req_validation = $this->validator->validate($request, [
            'id' => v::notEmpty(),
            'name' => v::notEmpty(),
            'group' =>  v::optional(v::intVal()),
            'email' =>  v::notEmpty()->email()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        if ($request->getParam('group') != "") $tmp_group = json_encode(['id' => $request->getParam('group')]);

        $user = User::find($request->getParam('id'));

        if ($request->getParam('name') != $user->name) $user->name = $request->getParam('name');
        if ($request->getParam('email') != $user->email) $user->email = $request->getParam('email');
        if (($request->getParam('group') != "") && ($tmp_group != $user->primaryGroup)) $user->primaryGroup = $tmp_group;

        if ($user->isDirty()) {
            $user->save();
        }

        return $response->withStatus(200);
    }

    public function changeUserPassword($request, $response) {
        $req_validation = $this->validator->validate($request, [
            'id' => v::notEmpty(),
            'password' =>  v::notEmpty()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $user = User::find($request->getParam('id'));

        $user->password = password_hash($request->getParam('password'), PASSWORD_DEFAULT);
        $user->save();

        return $response->withStatus(200);
    }
}
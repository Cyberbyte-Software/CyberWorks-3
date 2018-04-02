<?php

namespace CyberWorks\Core\Controllers\Auth;

use CyberWorks\Core\Auth\Auth;
use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Core\Models\Group;
use CyberWorks\Core\Models\User;
use CyberWorks\Core\Helper\EditLogger;
use LiveControl\EloquentDataTable\DataTable;
use Respect\Validation\Validator as v;

class UserController extends Controller
{
    public function index($request, $response) {
        $groups = Group::all();
        $data = ['groups' => $groups];
        return $this->view->render($response, 'users/index.twig', $data);
    }

    public function newUserView($request, $response) {
        $groups = Group::all();
        $data = ['groups' => $groups];
        return $this->view->render($response, 'users/new.twig', $data);
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
                '<a onclick=\'showUserEditBox('. $user->id .',"'. $user->name .'","'. $user->email .'",'. $group->id .')\'><i class="fa fa-pencil"></i></a> <a onclick=\'showUserEditPasswordBox('. $user->id .',"'. $user->name .'")\'><i class="fa fa-key"></i></a> <a onclick=\'deleteUserBox('. $user->id .',"'. $user->name .'")\'><i class="fa fa-trash"></i></a>'
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

        EditLogger::logEdit('5', "Updated User ". $user->name);

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

        EditLogger::logEdit('5', "Changed ". $user->name ." Password");

        return $response->withStatus(200);
    }

    public function newUser($request, $response) {
        $validation = $this->validator->validate($request, [
                'username' => v::noWhitespace()->notEmpty()->usernameAvailable(),
                'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
                'password' => v::noWhitespace()->notEmpty(),
                'group' => v::intVal()
            ]
        );

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('user.new'));
        }

        $picture = AuthController::get_gravatar($request->getParam('email'));
        $group = json_encode(['id' => $request->getParam('group')]);

        User::create([
            'email' => $request->getParam('email'),
            'name' => $request->getParam('username'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
            'primaryGroup' => $group,
            'profilePicture' => $picture,
        ]);

        EditLogger::logEdit('5', "Added User ". $request->getParam('username'));

        $this->alerts->addMessage('success', 'Account Created');
        return $response->withRedirect($this->router->pathFor('dashboard'));
    }

    public function deleteUser($request, $response) {
        $req_validation = $this->validator->validate($request, [
            'id' => v::notEmpty()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $user = User::find($request->getParam('id'));

        EditLogger::logEdit('5', "Deleted User ". $request->getParam('id') . " " . $user->name);

        $user->delete();


        return $response->withStatus(200);
    }
}
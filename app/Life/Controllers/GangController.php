<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 21/07/2017
 * Time: 12:55
 */

namespace CyberWorks\Life\Controllers;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Life\Helper\General;
use CyberWorks\Life\Models\Player;
use CyberWorks\Life\Models\Gang;
use CyberWorks\Life\Helper\LifeEditLogger;
use LiveControl\EloquentDataTable\DataTable;
use Respect\Validation\Validator as v;

class GangController extends Controller
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'life/gangs.twig');
    }

    public function table($request, $response)
    {
        $gangs = new Gang();
        $table = new DataTable($gangs->where('active', 1), ['id', 'owner', 'name', 'members', 'maxmembers', 'bank']);

        $table->setFormatRowFunction(function ($gang) {
            $membersString = "";
            $members = General::stripArray($gang->members, 3);

            $players = Player::whereIn('pid', $members)->get();

            foreach ($players as $player) {
                $membersString = $membersString . '<a href="player/' . $player->uid . '"target="_blank">' . $player->name . '</a>, ';
            }

            return [
                $gang->name,
                '<a href="player/' . $gang->owner_id . '"target="_blank">' . $gang->owner_name . '</a>',
                $gang->bank,
                $gang->maxmembers,
                $membersString,
                '<a onclick=\'showEditGangBox(' . $gang->id . ',' . $gang->owner . ',"' . str_replace('"', '\"', $gang->members) . '",' . $gang->bank . ',"' . $gang->name .'",'. $gang->maxmembers .')\'><i class="fa fa-pencil"></i></a>',
            ];
        });

        return $response->withJson($table->make());
    }

    public function updateGang($request, $response)
    {
        $req_validation = $this->validator->validate($request, [
            'id' => v::notEmpty(),
            'name' => v::notEmpty(),
            'owner' => v::optional(v::notEmpty()),
            'members' => v::optional(v::notEmpty()),
            'maxmembers' => v::optional(v::intVal()),
            'funds' => v::optional(v::intVal())
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors() ], 400);
        }

        $gang = Gang::find($request->getParam('id'));

        if (!$gang) {
            return $response->withJson(['error' => 'Gang Not Found'], 404);
        }

        LifeEditLogger::logEdit($request->getParam('id'), 2, "Edited Gang: Name Before: ".$gang->name." After ".$request->getParam('name')." Owner Before: ".$gang->owner." After ".$request->getParam('owner')." Funds Before: ".$gang->bank." After ".$request->getParam('funds')." Members Before: ".$gang->members." After ".$request->getParam('members')." Max Members Before: ".$gang->maxmembers." After ".$request->getParam('maxmembers'));

        $gang->name = $request->getParam('name');
        if (!is_null($request->getParam('owner'))) { $gang->owner = $request->getParam('owner'); }
        if (!is_null($request->getParam('funds'))) { $gang->bank = $request->getParam('funds'); }
        if (!is_null($request->getParam('members'))) { $gang->members = $request->getParam('members'); }
        if (!is_null($request->getParam('maxmembers'))) { $gang->maxmembers = $request->getParam('maxmembers'); }

        $gang->save();
        return $response->withStatus(200);
    }
}
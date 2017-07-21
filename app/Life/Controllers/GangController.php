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
use LiveControl\EloquentDataTable\DataTable;

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
            $player = Player::where('pid', $gang->owner)->first();

            $membersString = "";
            $members = General::stripArray($gang->members, 3);

            foreach ($members as $member) {
                $gangMember = Player::where('pid', $member)->first();
                $membersString = $membersString . '<a href="player/' . $gangMember->uid . '"target="_blank">' . $gangMember->name . '</a> ';
            }

            return [
                $gang->name,
                '<a href="player/' . $player->uid . '"target="_blank">' . $player->name . '</a>',
                $gang->bank,
                $gang->maxmembers,
                $membersString
            ];
        });

        return $response->withJson($table->make());
    }
}
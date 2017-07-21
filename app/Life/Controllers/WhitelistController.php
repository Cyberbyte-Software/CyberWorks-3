<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 20/07/2017
 * Time: 14:32
 */

namespace CyberWorks\Life\Controllers;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Core\Helper\General;
use CyberWorks\Life\Models\Player;
use CyberWorks\Life\Models\Whitelist;
use Respect\Validation\Validator as v;

class WhitelistController extends Controller
{
    public function addToWhitelist($request, $response)
    {
        $req_validation = $this->validator->validate($request, [
            'pid' => v::notEmpty()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $exists = Whitelist::find($request->getParam('pid'));

        if (!$exists) {
            $entry = new Whitelist();

            $entry->player_id = $request->getParam('pid');
            $entry->player_guid = General::guid($request->getParam('pid'));

            $entry->save();

            return $response->withJson(['success' => 'Finished'], 202);
        }

        return $response->withJson(['error' => 'Entry Exisited?'], 400);
    }

    public function delFromWhitelist($request, $response)
    {
        $req_validation = $this->validator->validate($request, [
            'pid' => v::notEmpty()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $entry = Whitelist::destroy($request->getParam('pid'));

        return $response->withJson(['success' => 'Finished?'], 202);
    }


//    public function gen($request, $response)
//    {
//        $players = Player::all();
//
//        foreach ($players as $player) {
//            $entry = new Whitelist();
//
//            $entry->player_id = $player->playerid;
//            $entry->player_guid = General::guid($player->playerid);
//
//            $entry->save();
//        }
//    }
}
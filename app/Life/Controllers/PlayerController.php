<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 26/06/2017
 * Time: 15:05
 */

namespace CyberWorks\Life\Controllers;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Life\Helper\EditLogger;
use CyberWorks\Life\Helper\General;
use CyberWorks\Life\Models\Player;
use LiveControl\EloquentDataTable\DataTable;
use Respect\Validation\Validator as v;

class PlayerController extends Controller
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'life/players.twig');
    }

    public function table($request, $response)
    {
        $players = new Player();
        $table = new DataTable($players, ['uid', 'name', 'pid', 'bankacc', 'cash', 'coplevel', 'mediclevel', 'adminlevel']);

        $table->setFormatRowFunction(function ($player) {
            return [
                '<a href="player/' . $player->uid . '"target="_blank">' . $player->name . '</a>',
                '<a href="http://steamcommunity.com/profiles/' . $player->pid . '"target="_blank">' . $player->pid . '</a>',
                $player->bankacc,
                $player->cash,
                $player->coplevel,
                $player->mediclevel,
                $player->adminlevel,
                '<a href="player/' . $player->uid . '"target="_blank"><i class="fa fa-pencil"></i></a>'
            ];
        });

        return $response->withJson($table->make());
    }

    public function player($request, $response, $args)
    {
        $player = Player::find($args['id']);

        if (!$player) {
            $this->alerts->addMessage("error", "Player Not Found");
            return $response->withRedirect($this->router->pathFor('dashboard'));
        }

        if ($player->civ_licenses !== '"[]"' && $player->civ_licenses !== '') $player->civ_licenses = General::processLicenses($player->civ_licenses);
        if ($player->cop_licenses !== '"[]"' && $player->cop_licenses !== '') $player->cop_licenses = General::processLicenses($player->cop_licenses);
        if ($player->med_licenses !== '"[]"' && $player->med_licenses !== '') $player->med_licenses = General::processLicenses($player->med_licenses);

        $player->guid = General::guid($player->pid);

        return $this->view->render($response, 'life/player.twig', ["player" => $player]);
    }

    public function compensate($request, $response, $args)
    {
        $req_validation = $this->validator->validate($request, [
            'value' => v::notEmpty()->intVal()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $player = Player::find($args['id']);

        EditLogger::logPlayerEdit("Compensated Players Bank Account With $" . (int) $request->getParam("value"), $args['id']);

        $bank = $player->bankacc + (int) $request->getParam("value");
        $player->bankacc = $bank;
        $player->save();

        return $response;
    }

    public function updateBank($request, $response, $args)
    {
        $req_validation = $this->validator->validate($request, [
            'value' => v::intVal()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $player = Player::find($args['id']);

        EditLogger::logPlayerEdit("Edited Players Bank Account Before: $" . $player->bankacc . " After: $" . (int) $request->getParam("value"), $args['id']);

        $player->bankacc = (int) $request->getParam("value");
        $player->save();

        return $response;
    }

    public function updateCash($request, $response, $args)
    {
        $req_validation = $this->validator->validate($request, [
            'value' => v::intVal()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $player = Player::find($args['id']);

        EditLogger::logPlayerEdit("Edited Players Cash Before: $" . $player->cash . " After: $" . (int) $request->getParam("value"), $args['id']);

        $player->cash = (int) $request->getParam("value");
        $player->save();

        return $response;
    }

    public function updateArrestedState($request, $response, $args)
    {
        $player = Player::find($args['id']);

        EditLogger::logPlayerEdit("Edited Players Arrested State Before: " . $player->arrested . " After: " . (int) $request->getParam("value"), $args['id']);

        $player->arrested = (int) $request->getParam("value");
        $player->save();

        return $response;
    }

    public function updateCopRank($request, $response, $args)
    {
        $req_validation = $this->validator->validate($request, [
            'value' => v::intVal()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $player = Player::find($args['id']);

        EditLogger::logPlayerEdit("Edited Players Cop Rank Before: " . $player->coplevel . " After: " . $request->getParam("value"), $args['id']);

        $player->coplevel = $request->getParam("value");
        $player->save();

        return $response;
    }

    public function updateMedicRank($request, $response, $args)
    {
        $req_validation = $this->validator->validate($request, [
            'value' => v::intVal()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $player = Player::find($args['id']);

        EditLogger::logPlayerEdit("Edited Players Ems Rank Before: " . $player->mediclevel . " After: " . $request->getParam("value"), $args['id']);

        $player->mediclevel = $request->getParam("value");
        $player->save();

        return $response;
    }

    public function updateAdminRank($request, $response, $args)
    {
        $req_validation = $this->validator->validate($request, [
            'value' => v::intVal()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $player = Player::find($args['id']);

        EditLogger::logPlayerEdit("Edited Players Admin Rank Before: " . $player->adminlevel . " After: " . $request->getParam("value"), $args['id']);

        $player->adminlevel = $request->getParam("value");
        $player->save();

        return $response;
    }

    public function updateDonatorRank($request, $response, $args)
    {
        $req_validation = $this->validator->validate($request, [
            'value' => v::intVal()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $player = Player::find($args['id']);

        EditLogger::logPlayerEdit("Edited Players Donator Rank Before: " . $player->donatorlvl . " After: " . $request->getParam("value"), $args['id']);

        $player->donorlevel = $request->getParam("value");
        $player->save();

        return $response;
    }

    public function updateLicense($request, $response, $args)
    {
        $req_validation = $this->validator->validate($request, [
            'name' => v::notEmpty()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed'], 400);
        }

        $exploded = explode("_", $args['name']);
        $side = $exploded[1];
        $player = Player::find($args['id']);

        switch ($side)
        {
            case "civ":
                $position = strpos($player->civ_licenses, $exploded['2']) + strlen($exploded['2']) + 2;
                $tmp = $player->civ_licenses;
                $tmp[$position] = General::switchValue((int) $player->civ_licenses[$position]);
                EditLogger::logPlayerEdit("Edited Players " . $args['name'] . " Before: " . $player->civ_licenses[$position] . " After: " . $tmp[$position], $args['id']);
                $player->civ_licenses = $tmp;
                break;
            case "cop":
                $position = strpos($player->cop_licenses, $exploded['2']) + strlen($exploded['2']) + 2;
                $tmp = $player->cop_licenses;
                $tmp[$position] = General::switchValue((int) $player->cop_licenses[$position]);
                EditLogger::logPlayerEdit("Edited Players " . $args['name'] . " Before: " . $player->cop_licenses[$position] . " After: " . $tmp[$position], $args['id']);
                $player->cop_licenses = $tmp;
                break;
            case "med":
                $position = strpos($player->med_licenses, $exploded['2']) + strlen($exploded['2']) + 2;
                $tmp = $player->med_licenses;
                $tmp[$position] = General::switchValue((int) $player->med_licenses[$position]);
                EditLogger::logPlayerEdit("Edited Players " . $args['name'] . " Before: " . $player->med_licenses[$position] . " After: " . $tmp[$position], $args['id']);
                $player->med_licenses = $tmp;
                break;
        }

        $player->save();

        return $response;
    }
}
<?php

namespace CyberWorks\Life\Controllers;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Life\Helper\LifeEditLogger;
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
                '<a href="https://steamcommunity.com/profiles/' . $player->pid . '"target="_blank">' . $player->pid . '</a>',
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
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $player = Player::find($args['id']);

        LifeEditLogger::logEdit($args['id'], 0, "Compensated Players Bank Account With $" . (int) $request->getParam("value"));

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
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $player = Player::find($args['id']);

        LifeEditLogger::logEdit($args['id'], 0,"Edited Players Bank Account Before: $" . $player->bankacc . " After: $" . (int) $request->getParam("value"));

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
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $player = Player::find($args['id']);

        LifeEditLogger::logEdit($args['id'], 0,"Edited Players Cash Before: $" . $player->cash . " After: $" . (int) $request->getParam("value"));

        $player->cash = (int) $request->getParam("value");
        $player->save();

        return $response;
    }

    public function updateArrestedState($request, $response, $args)
    {
        $player = Player::find($args['id']);

        LifeEditLogger::logEdit($args['id'], 0,"Edited Players Arrested State Before: " . $player->arrested . " After: " . (int) $request->getParam("value"));

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
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $player = Player::find($args['id']);

        LifeEditLogger::logEdit($args['id'], 0,"Edited Players Cop Rank Before: " . $player->coplevel . " After: " . $request->getParam("value"));

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
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $player = Player::find($args['id']);

        LifeEditLogger::logEdit($args['id'], 0,"Edited Players Ems Rank Before: " . $player->mediclevel . " After: " . $request->getParam("value"));

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
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $player = Player::find($args['id']);

        LifeEditLogger::logEdit($args['id'], 0,"Edited Players Admin Rank Before: " . $player->adminlevel . " After: " . $request->getParam("value"));

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
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $player = Player::find($args['id']);

        LifeEditLogger::logEdit($args['id'], 0,"Edited Players Donator Rank Before: " . $player->donatorlvl . " After: " . $request->getParam("value"));

        $player->donorlevel = $request->getParam("value");
        $player->save();

        return $response;
    }

    public function updateLicense($request, $response, $args)
    {
        $find_text = "`" . $args['name'] . "`";
        $allowed_sides = ["civ", "med", "cop"];
        $exploded = explode("_", $args['name']);
        $side = $exploded[1];
        if (!in_array($side, $allowed_sides)) {
            return $response->withJson(['error' => 'Invalid side']);
        }
        
        $player = Player::find($args['id']);
        $property = $side . "_licenses";
                                        
        $inital_position = strpos($player->$property, $find_text);
        if ($inital_position === false) {
            return $response->withJson(['error' => 'Invalid licence name']);
        }
        
        $position = $inital_position + strlen($find_text) + 1;
        $tmp = $player->$property;
        $tmp[$position] = General::switchValue((int) $player->civ_licenses[$position]);
        LifeEditLogger::logEdit($args['id'], 0, "Edited player licence " . $args['name'] . " Before: " . $player->$property[$position] . " After: " . $tmp[$position]);
        $player->$property = $tmp;
        $player->save();

        return $response;
    }
}

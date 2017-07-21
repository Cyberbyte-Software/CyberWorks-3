<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 09:39
 */

namespace CyberWorks\Core\Controllers;

use CyberWorks\Life\Models\Player;
use Illuminate\Database\Capsule\Manager as DB;

class HomeController extends Controller
{
    public function index($request, $response)
    {
        $richPlayers = Player::orderBy('bankacc', 'desc')->take(10)->get();
        $repPlayers = Player::orderBy('cash', 'desc')->take(10)->get();
        $newestPlayer = DB::select("SELECT name FROM players ORDER BY insert_time DESC LIMIT 1");

        $data = ['players' => Player::count(), 'richPlayers' => $richPlayers, 'highRepPlayers' => $repPlayers, 'newestPlayer' => $newestPlayer[0]->name];

        return $this->view->render($response, 'home.twig', $data);
    }

    public function stats($request, $response)
    {
        return $this->view->render($response, 'stats.twig');
    }
}
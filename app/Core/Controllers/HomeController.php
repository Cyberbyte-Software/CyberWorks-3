<?php


namespace CyberWorks\Core\Controllers;

use CyberWorks\Life\Models\Player;
use CyberWorks\Life\Models\Vehicle;
use CyberWorks\Life\Models\House;
use Illuminate\Database\Capsule\Manager as DB;

class HomeController extends Controller
{
    public function index($request, $response)
    {
        $richPlayers = Player::orderBy('bankacc', 'desc')->take(10)->get();
        $richPlayersCash = Player::orderBy('cash', 'desc')->take(10)->get();
        $newestPlayer = DB::select("SELECT name FROM players ORDER BY insert_time DESC LIMIT 1");
        $vehCount = Vehicle::all()->count();
        $houseCount = House::all()->count();

        $data = ['players' => Player::count(), 'richPlayers' => $richPlayers, 'richPlayersCash' => $richPlayersCash, 'newestPlayer' => $newestPlayer[0]->name, 'veh_count' => $vehCount, 'house_count' => $houseCount];

        return $this->view->render($response, 'home.twig', $data);
    }

    public function stats($request, $response)
    {
        return $this->view->render($response, 'stats.twig');
    }
}
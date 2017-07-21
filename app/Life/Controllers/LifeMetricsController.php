<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 21/07/2017
 * Time: 11:29
 */

namespace CyberWorks\Life\Controllers;

use CyberWorks\Core\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;

class LifeMetricsController extends Controller
{
    public function playerMetrics($request, $response)
    {
        $users = DB::select("SELECT users.name, count(*) as count FROM cw_logs log INNER JOIN cw_users users ON users.id = log.user_id WHERE type = '0' GROUP BY users.name ORDER BY users.id");

        $forum_metrics = [];
        $forum_names = [];

        foreach ($users as $user) {
            if ($user->count > 0) {
                $forum_metrics[] = $user->count;
                $forum_names[] = $user->name;
            }
        }

        return $response->withJson(['metricdata' => $forum_metrics, 'labels' => $forum_names]);
    }

    public function factionMetrics($request, $response)
    {
        $cops = DB::select("SELECT count(*) as count FROM players WHERE coplevel != '0'");
        $ems = DB::select("SELECT count(*) as count FROM players WHERE mediclevel != '0'");
        $civs = DB::select("SELECT count(*) as count FROM players WHERE coplevel = '0' && mediclevel = '0'");

        return $response->withJson(['metricdata' => [$cops[0]->count, $ems[0]->count, $civs[0]->count], 'labels' => ['Cops', 'Medics', 'Civs']]);
    }

}
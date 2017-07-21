<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 17/07/2017
 * Time: 23:40
 */

namespace CyberWorks\Core\Controllers\API;

use CyberWorks\Core\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;

class MetricsController extends Controller
{
    public function allMetrics($request, $response)
    {
        $users = DB::select("SELECT users.name, count(*) as count FROM cw_logs log INNER JOIN cw_users users ON users.id = log.user_id GROUP BY users.name ORDER BY users.id");

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
}
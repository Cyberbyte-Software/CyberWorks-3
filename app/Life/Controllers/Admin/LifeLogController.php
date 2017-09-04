<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 29/06/2017
 * Time: 13:54
 */

namespace CyberWorks\Life\Controllers\Admin;

use CyberWorks\Core\Models\Log;
use LiveControl\EloquentDataTable\DataTable;
use CyberWorks\Core\Controllers\Controller;

class LogController extends Controller
{
    public function playerIndex($request, $response)
    {
        return $this->view->render($response, 'logs/player.twig');
    }

    public function playerTable($request, $response)
    {
        $logs = new Log();
        $table = new DataTable($logs->where('type', '0')->orderBy('created_at', 'desc'), ['id', 'message', 'user_id', 'player_id', 'created_at']);

        $table->setFormatRowFunction(function ($log) {
            return [
                '<a href="' . $log->profileUrl . '"target="_blank">' . $log->name . '</a>',
                '<a href="player/' . $log->player_id . '"target="_blank">' . $log->playerName . '</a>',
                $log->message,
                (string) $log->created_at
            ];
        });

        return $response->withJson($table->make());
    }

    public function playerEditLog($request, $response, $args)
    {
        $logs = new Log();
        $table = new DataTable($logs->where('player_id', $args['id'])->orderBy('created_at', 'desc'), ['id', 'message', 'user_id', 'player_id', 'created_at']);

        $table->setFormatRowFunction(function ($log) {
            return [
                '<a href="' . $log->profileUrl . '"target="_blank">' . $log->name . '</a>',
                $log->message,
                (string) $log->created_at
            ];
        });

        return $response->withJson($table->make());
    }
}
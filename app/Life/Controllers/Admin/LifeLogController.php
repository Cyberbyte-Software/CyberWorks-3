<?php

namespace CyberWorks\Life\Controllers\Admin;

use CyberWorks\Core\Models\Log;
use LiveControl\EloquentDataTable\DataTable;
use CyberWorks\Core\Controllers\Controller;

class LifeLogController extends Controller
{
    public function playerIndex($request, $response)
    {
        return $this->view->render($response, 'logs/logTable.twig', ['title' => 'life.player.title', 'col' => 'life.player.title', 'api' => 'player']);
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

    /*
     * This is the log shown on the player page
     */
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

    public function vehicleIndex($request, $response)
    {
        return $this->view->render($response, 'logs/logTable.twig', ['title' => 'life.vehicles.titleSingle', 'col' => 'life.vehicles.id', 'api' => 'vehicle']);
    }

    public function vehicleTable($request, $response)
    {
        $logs = new Log();
        $table = new DataTable($logs->where('type', '1')->orderBy('created_at', 'desc'), ['id', 'message', 'user_id', 'vehicle_id', 'created_at']);

        $table->setFormatRowFunction(function ($log) {
            return [
                '<a href="' . $log->profileUrl . '"target="_blank">' . $log->name . '</a>',
                $log->vehicle_id,
                $log->message,
                (string) $log->created_at
            ];
        });

        return $response->withJson($table->make());
    }

    public function gangIndex($request, $response)
    {
        return $this->view->render($response, 'logs/logTable.twig', ['title' => 'life.gangs.titleSingle', 'col' => 'life.gangs.titleSingle', 'api' => 'gang']);
    }

    public function gangTable($request, $response)
    {
        $logs = new Log();
        $table = new DataTable($logs->where('type', '2')->orderBy('created_at', 'desc'), ['id', 'message', 'user_id', 'gang_id', 'created_at']);

        $table->setFormatRowFunction(function ($log) {
            return [
                '<a href="' . $log->profileUrl . '"target="_blank">' . $log->name . '</a>',
                $log->gangName,
                $log->message,
                (string) $log->created_at
            ];
        });

        return $response->withJson($table->make());
    }

    public function containerIndex($request, $response)
    {
        return $this->view->render($response, 'logs/logTable.twig', ['title' => 'life.containers.titleSingle', 'col' => 'life.containers.id', 'api' => 'container']);
    }

    public function containerTable($request, $response)
    {
        $logs = new Log();
        $table = new DataTable($logs->where('type', '3')->orderBy('created_at', 'desc'), ['id', 'message', 'user_id', 'container_id', 'created_at']);

        $table->setFormatRowFunction(function ($log) {
            return [
                '<a href="' . $log->profileUrl . '"target="_blank">' . $log->name . '</a>',
                $log->container_id,
                $log->message,
                (string) $log->created_at
            ];
        });

        return $response->withJson($table->make());
    }


    public function houseIndex($request, $response)
    {
        return $this->view->render($response, 'logs/logTable.twig', ['title' => 'life.houses.titleSingle', 'col' => 'life.houses.id', 'api' => 'house']);
    }

    public function houseTable($request, $response)
    {
        $logs = new Log();
        $table = new DataTable($logs->where('type', '4')->orderBy('created_at', 'desc'), ['id', 'message', 'user_id', 'house_id', 'created_at']);

        $table->setFormatRowFunction(function ($log) {
            return [
                '<a href="' . $log->profileUrl . '"target="_blank">' . $log->name . '</a>',
                $log->house_id,
                $log->message,
                (string) $log->created_at
            ];
        });

        return $response->withJson($table->make());
    }
}
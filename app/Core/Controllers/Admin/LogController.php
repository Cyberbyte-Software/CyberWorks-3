<?php

namespace CyberWorks\Core\Controllers\Admin;

use CyberWorks\Core\Models\Log;
use LiveControl\EloquentDataTable\DataTable;
use CyberWorks\Core\Controllers\Controller;

class LogController extends Controller
{
    public function userIndex($request, $response)
    {
        return $this->view->render($response, 'logs/adminLogTable.twig', ['title' => 'core.perms.users.log', 'api' => 'user']);
    }

    public function userTable($request, $response)
    {
        $logs = new Log();
        $table = new DataTable($logs->where('type', '5')->orderBy('created_at', 'desc'), ['id', 'message', 'user_id', 'created_at']);

        $table->setFormatRowFunction(function ($log) {
            return [
                $log->name,
                $log->message,
                (string) $log->created_at
            ];
        });

        return $response->withJson($table->make());
    }

    public function groupIndex($request, $response)
    {
        return $this->view->render($response, 'logs/adminLogTable.twig', ['title' => 'core.perms.group.log', 'api' => 'group']);
    }

    public function groupTable($request, $response)
    {
        $logs = new Log();
        $table = new DataTable($logs->where('type', '6')->orderBy('created_at', 'desc'), ['id', 'message', 'user_id', 'created_at']);

        $table->setFormatRowFunction(function ($log) {
            return [
                $log->name,
                $log->message,
                (string) $log->created_at
            ];
        });

        return $response->withJson($table->make());
    }
}
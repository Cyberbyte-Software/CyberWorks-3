<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 30/06/2017
 * Time: 11:54
 */

namespace CyberWorks\Life\Controllers\Admin;

use CyberWorks\Life\Helper\EditLogger;
use CyberWorks\Life\Models\Note;
use CyberWorks\Core\Controllers\Controller;
use LiveControl\EloquentDataTable\DataTable;

class NoteController extends Controller
{
    public function playerNotes($request, $response, $args)
    {
        $notes = new Note();
        $table = new DataTable($notes->where('player_id', $args['id']), ['id', 'type', 'message', 'user_id', 'player_id', 'created_at']);

        $table->setFormatRowFunction(function ($note) {
            switch ($note->type) {
                case 0:
                    $name = "Information";
                    break;
                case 1:
                    $name = "Warning";
                    break;
                case 2:
                    $name = "Other";
                    break;
            }

            return [
                '<a href="' . $note->profileUrl . '"target="_blank">' . $note->name . '</a>',
                $name,
                $note->message,
                (string) $note->created_at,
                '<a onclick="deleteNote('.$note->id.')"><i class="fa fa-trash"></i></a>',
            ];
        });

        return $response->withJson($table->make());
    }

    public function addNote($request, $response, $args)
    {
        //USE THE FUCKING VALIDATOR
        $type = $request->getParam('type');
        if ($type > 2) $type = 2;

        $msg = $request->getParam('msg');

        if ($msg == "") {
            $body = new \Slim\Http\Body(fopen('php://temp', 'r+'));
            $body->write('Message Cant Be Blank!');
            return $response->withStatus(400)->withHeader('Content-type', 'text/plain')->withBody($body);
        }

        $note = new Note();
        $note->user_id = $_SESSION['user_id'];
        $note->player_id = $args['id'];
        $note->message = $msg;
        $note->type = $type;
        $note->save();

        return $response;
    }

    public function deleteNote($request, $response)
    {
        $note = Note::find($request->getParam('noteID'));

        if (!$note) {
            $body = new \Slim\Http\Body(fopen('php://temp', 'r+'));
            $body->write('Note Not Found!');
            return $response->withStatus(404)->withHeader('Content-type', 'text/plain')->withBody($body);
        }

        switch ($note->type) {
            case 0:
                $name = "Information";
                break;
            case 1:
                $name = "Warning";
                break;
            case 2:
                $name = "Other";
                break;
        }

        EditLogger::logPlayerEdit("Removed A Note From The Account. Type: ". $name .". Message: " . $note->message, $note->player_id);

        Note::destroy($request->getParam('noteID'));

        return $response->withStatus(200);
    }
}
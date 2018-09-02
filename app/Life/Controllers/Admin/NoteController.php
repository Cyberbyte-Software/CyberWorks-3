<?php

namespace CyberWorks\Life\Controllers\Admin;

use CyberWorks\Life\Helper\LifeEditLogger;
use CyberWorks\Life\Models\Note;
use CyberWorks\Core\Controllers\Controller;
use LiveControl\EloquentDataTable\DataTable;
use Respect\Validation\Validator as v;

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
        $req_validation = $this->validator->validate($request, [
            'msg' => v::notEmpty(),
            'type' => v::intVal()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(["error" => "Message Cant Be Blank!"], 400);
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

        $type = $request->getParam('type');
        if ($type > 2) $type = 2;

        $note = new Note();
        $note->user_id = $_SESSION['user_id'];
        $note->player_id = $args['id'];
        $note->message = $request->getParam('msg');
        $note->type = $type;
        $note->save();

        LifeEditLogger::logEdit($note->player_id, 0, "Added A Note To The Account. Type: ". $name .". Message: " . $note->message);

        return $response;
    }

    public function deleteNote($request, $response)
    {
        $note = Note::find($request->getParam('noteID'));

        if (!$note) {
            return $response->withJson(["error" => "Note Not Found!"], 404);
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

        LifeEditLogger::logEdit($note->player_id, 0, "Removed A Note From The Account. Type: ". $name .". Message: " . $note->message);

        Note::destroy($request->getParam('noteID'));

        return $response->withStatus(200);
    }
}

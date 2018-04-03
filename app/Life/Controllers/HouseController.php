<?php

namespace CyberWorks\Life\Controllers;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Life\Helper\LifeEditLogger;
use CyberWorks\Life\Models\House;
use LiveControl\EloquentDataTable\DataTable;
use Respect\Validation\Validator as v;

class HouseController extends Controller
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'life/houses.twig');
    }

    public function table($request, $response)
    {
        $houses = new House();
        $table = new DataTable($houses->where('owned', 1), ['id', 'pid', 'pos']);

        $table->setFormatRowFunction(function ($house) {
            return [
                '<a href="player/' . $house->owner_id . '"target="_blank">' . $house->owner . '</a>',
                $house->pos,
                '<a onclick=\'showHouseEdit('. $house->id .',"'. $house->pid .'","'. str_replace('"', '\"', $house->pos) .'")\'><i class="fa fa-pencil"></i></a>',
            ];
        });

        return $response->withJson($table->make());
    }

    public function updateHouse($request, $response)
    {
        $req_validation = $this->validator->validate($request, [
            'id' => v::notEmpty(),
            'pos' => v::notEmpty(),
            'owner' => v::notEmpty()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors() ], 400);
        }

        $house = House::find($request->getParam('id'));

        if (!$house) {
            return $response->withJson(['error' => 'House Not Found'], 404);
        }

        LifeEditLogger::logEdit($request->getParam('id'), 4, "Updated House: Owner Before: ". $house->pid ." After: ". $request->getParam('owner') ." Position Before: ". $house->pos ." After: ". $request->getParam('pos'));

        if ($house->pid != $request->getParam('owner')) $house->pid = $request->getParam('owner');
        if ($house->pos != $request->getParam('pos')) $house->pos = $request->getParam('pos');

        if ($house->isDirty()) $house->save();
    }
}
<?php 

namespace CyberWorks\Life\Controllers;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Life\Models\Vehicle;
use CyberWorks\Life\Models\Player;
use LiveControl\EloquentDataTable\DataTable;
use Respect\Validation\Validator as v;
use CyberWorks\Life\Helper\LifeEditLogger;

class VehicleController extends Controller
{
    public function index($request, $response)
    {
       return $this->view->render($response, 'life/vehicles.twig');
    }

    public function vehicle($request, $response, $args)
    {
        $vehicle = Vehicle::find($args['id']);
		return $this->view->render($response, 'life/vehicle.twig', ['vehicle' => $vehicle]);
    }

    public function table($request, $response)
    {
        $vehicles = new Vehicle();
        $table = new DataTable($vehicles, ['id', 'side', 'classname', 'type', 'pid', 'alive', 'active', 'plate', 'color', 'inventory']);

        $table->setFormatRowFunction(function ($vehicle) {
            return [
                $vehicle->classname,
                '<a href="player/' . $vehicle->owner_id . '">' . $vehicle->owner . '</a>',
                $vehicle->side,
                $vehicle->type,
                $vehicle->alive,
                $vehicle->active,
                $vehicle->plate,
                $vehicle->color,
                $vehicle->inventory,
                '<a onclick=\'showVehicleEditBox(' . $vehicle->id . ',' . $vehicle->active . ',' . $vehicle->alive . ',"' . $vehicle->classname . '","' . $vehicle->side . '")\'><i class="fa fa-pencil"></i></a>',
            ];
        });

        return $response->withJson($table->make());
    }

    public function vehicleTable($request, $response, $args)
    {
        $player = Player::find($args['id']);
        $vehicle = new Vehicle();
        $table = new DataTable($vehicle->where('pid', $player->pid), ['id', 'side', 'classname', 'type', 'pid', 'alive', 'active', 'plate', 'color', 'inventory']);

        $table->setFormatRowFunction(function ($vehicle) {
            return [
                $vehicle->classname,
                $vehicle->side,
                $vehicle->type,
                $vehicle->alive,
                $vehicle->active,
                $vehicle->plate,
                $vehicle->color,
                $vehicle->inventory
            ];
        });

        return $response->withJson($table->make());
    }

    public function updateVehicle($request, $response) {
        $req_validation = $this->validator->validate($request, [
            'id' => v::notEmpty(),
            'classname' => v::optional(v::notEmpty()),
            'dead' => v::intVal(),
            'garage' => v::intVal(),
            'fuel' => v::intVal(),
            'damage' => v::intVal(),
            'side' => v::notEmpty()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $vehicle = Vehicle::find($request->getParam('id'));

        if (!$vehicle) {
            return $response->withJson(['error' => 'Vehicle Not Found'], 404);
        }

        LifeEditLogger::logEdit($request->getParam('id'), 1,"Edited Vehicle. Garage Before: ". $vehicle->active ." After: ". $request->getParam('garage') ." Alive Before: ". $vehicle->alive ." Alive After: " . $request->getParam('dead'));

        $vehicle->alive = $request->getParam('dead');
        $vehicle->active = $request->getParam('garage');
        if ($request->getParam('side') != $vehicle->side) $vehicle->side = $request->getParam('side');
        if ($request->getParam('fuel') == 1) $vehicle->fuel = 1;
        if ($request->getParam('damage') == 1) $vehicle->damage = '"[]"';
        if ($request->getParam('classname') != "") $vehicle->classname = $request->getParam('classname');

        if($vehicle->isDirty()) $vehicle->save();

        return $response->withStatus(200);
    }
}
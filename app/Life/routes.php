<?php

use CyberWorks\Core\Middleware\AuthenticatedMiddleware;
use CyberWorks\Core\Middleware\Permissions\API\HasPermissionAPIMiddleware;
use CyberWorks\Core\Middleware\Permissions\HasPermissionMiddleware;
use CyberWorks\Life\Middleware\PlayerIsValidAPIMiddleware;

$app->group("", function() {
    $this->get('/players', 'PlayerController:index')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_players"))->setName('players');
    $this->get('/player/{id}', 'PlayerController:player')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_player"))->setName('player');

    $this->get('/vehicles', 'VehicleController:index')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_vehicles"))->setName('vehicles');
    $this->get('/gangs', 'GangController:index')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_gangs"))->setName('gangs');
    $this->get('/containers', 'ContainerController:index')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_containers"))->setName('containers');
    $this->get('/houses', 'HouseController:index')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_houses"))->setName('houses');

    $this->group("/logs", function () {
        $container = $this->getContainer();
        $this->get('/player', 'LifeLogController:playerIndex')->add(new HasPermissionMiddleware($container, "can_view_logs"))->setName('logs.player');
        $this->get('/vehicle', 'LifeLogController:vehicleIndex')->add(new HasPermissionMiddleware($container, "can_view_logs"))->setName('logs.vehicle');
        $this->get('/gang', 'LifeLogController:gangIndex')->add(new HasPermissionMiddleware($container, "can_view_logs"))->setName('logs.gang');
        $this->get('/container', 'LifeLogController:containerIndex')->add(new HasPermissionMiddleware($container, "can_view_logs"))->setName('logs.container');
        $this->get('/house', 'LifeLogController:houseIndex')->add(new HasPermissionMiddleware($container, "can_view_logs"))->setName('logs.house');
    });
})->add(new AuthenticatedMiddleware($app->getContainer()));

$app->group("/api/internal", function() {
    $this->post('/vehicles', 'VehicleController:table')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_vehicles"))->setName('api.vehicles');
    $this->post('/vehicle', 'VehicleController:updateVehicle')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_edit_vehicle"))->setName('api.vehicle.edit');

    $this->post('/gangs', 'GangController:table')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_gangs"))->setName('api.gangs');
    $this->post('/gang', 'GangController:updateGang')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_edit_gang"))->setName('api.gang.edit');

    $this->post('/players', 'PlayerController:table')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_players"))->setName('api.players');

    $this->post('/containers', 'ContainerController:table')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_containers"))->setName('api.containers');
    $this->post('/container', 'ContainerController:updateContainer')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_edit_container"))->setName('api.containers.update');

    $this->post('/houses', 'HouseController:table')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_houses"))->setName('api.houses');
    $this->post('/house', 'HouseController:updateHouse')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_edit_house"))->setName('api.houses.update');

    $this->group("/metrics", function() {
        $this->get('/faction', 'LifeMetricsController:factionMetrics')->setName('api.metrics.faction');
        $this->get('/players', 'LifeMetricsController:playerMetrics')->setName('api.metrics.players');
    });

    $this->group("/player/{id}", function() {
        $container = $this->getContainer();
        $this->post('/compensate', 'PlayerController:compensate')->add(new HasPermissionAPIMiddleware($container, "can_compensate"))->setName('api.player.compensate');
        $this->post('/license/{name}', 'PlayerController:updateLicense')->add(new HasPermissionAPIMiddleware($container, "can_edit_civ_lic"))->setName('api.player.license');
        $this->post('/addnote', 'NoteController:addNote')->add(new HasPermissionAPIMiddleware($container, "can_add_note"))->setName('api.player.addnote');
        $this->post('/arrested', 'PlayerController:updateArrestedState')->add(new HasPermissionAPIMiddleware($container, "can_edit_jailed"))->setName('api.player.arrested');
        $this->post('/admin', 'PlayerController:updateAdminRank')->add(new HasPermissionAPIMiddleware($container, "can_edit_admin_rank"))->setName('api.player.admin');
        $this->post('/donator', 'PlayerController:updateDonatorRank')->add(new HasPermissionAPIMiddleware($container, "can_edit_donator"))->setName('api.player.donator');
        $this->post('/bank', 'PlayerController:updateBank')->add(new HasPermissionAPIMiddleware($container, "can_edit_bank"))->setName('api.player.bank');
        $this->post('/cash', 'PlayerController:updateCash')->add(new HasPermissionAPIMiddleware($container, "can_edit_cash"))->setName('api.player.cash');
        $this->post('/cop', 'PlayerController:updateCopRank')->add(new HasPermissionAPIMiddleware($container, "can_edit_cop_rank"))->setName('api.player.cop');
        $this->post('/cop-license/{name}', 'PlayerController:updateLicense')->add(new HasPermissionAPIMiddleware($container, "can_edit_cop_lic"))->setName('api.player.license');
        $this->post('/medic', 'PlayerController:updateMedicRank')->add(new HasPermissionAPIMiddleware($container, "can_edit_ems_rank"))->setName('api.player.medic');
        $this->post('/ems-license/{name}', 'PlayerController:updateLicense')->add(new HasPermissionAPIMiddleware($container, "can_edit_ems_lic"))->setName('api.player.license');
    })->add(new PlayerIsValidAPIMiddleware($this->getContainer()))->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_player"));

    $this->group("/note", function () {
        $this->post('/delete', 'NoteController:deleteNote')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_delete_note"))->setName('api.note.delete');
    });

    $this->group("/player", function () {
        $container = $this->getContainer();
        $this->post('/{id}/vehicles', 'VehicleController:vehicleTable')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_player_vehicles"))->setName('api.player.vehicles');
        $this->post('/{id}/notes', 'NoteController:playerNotes')->add(new HasPermissionAPIMiddleware($container, "can_view_player_notes"))->setName('api.player.notes');
        $this->post('/{id}/logs', 'LifeLogController:playerEditLog')->add(new HasPermissionAPIMiddleware($container, "can_view_player_edit_log"))->setName('api.player.editLog');
    });

    $this->group("/logs", function () {
        $container = $this->getContainer();
        $this->post('/player', 'LifeLogController:playerTable')->add(new HasPermissionAPIMiddleware($container, "can_view_logs"))->setName('api.logs.player');
        $this->post('/vehicle', 'LifeLogController:vehicleTable')->add(new HasPermissionAPIMiddleware($container, "can_view_logs"))->setName('api.logs.vehicle');
        $this->post('/gang', 'LifeLogController:gangTable')->add(new HasPermissionAPIMiddleware($container, "can_view_logs"))->setName('api.logs.gang');
        $this->post('/house', 'LifeLogController:houseTable')->add(new HasPermissionAPIMiddleware($container, "can_view_logs"))->setName('api.logs.house');
        $this->post('/container', 'LifeLogController:containerTable')->add(new HasPermissionAPIMiddleware($container, "can_view_logs"))->setName('api.logs.container');
    });
})->add(new AuthenticatedMiddleware($app->getContainer()));
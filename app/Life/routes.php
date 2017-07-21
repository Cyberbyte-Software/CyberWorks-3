<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 19/07/2017
 * Time: 03:48
 */
use CyberWorks\Core\Middleware\AuthenticatedMiddleware;
use CyberWorks\Core\Middleware\Permissions\API\HasPermissionAPIMiddleware;
use CyberWorks\Core\Middleware\Permissions\HasPermissionMiddleware;
use CyberWorks\Life\Middleware\PlayerIsValidAPIMiddleware;

$app->group("", function() {
    $this->get('/players', 'PlayerController:index')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_players"))->setName('players');
    $this->get('/player/{id}', 'PlayerController:player')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_player"))->setName('player');
    $this->get('/vehicles', 'VehicleController:index')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_vehicles"))->setName('vehicles');
    $this->get('/vehicle/{id}', 'VehicleController:vehicle')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_vehicle"))->setName('vehicle');
    $this->get('/gangs', 'GangController:index')->add(new HasPermissionMiddleware($this->getContainer(), "can_view_gangs"))->setName('gangs');
})->add(new AuthenticatedMiddleware($app->getContainer()));

$app->group("/api", function() {
    $this->group("/metrics", function() {
        $this->get('/faction', 'LifeMetricsController:factionMetrics')->setName('api.metrics.faction');
        $this->get('/players', 'LifeMetricsController:playerMetrics')->setName('api.metrics.players');
    });

    $this->post('/players', 'PlayerController:table')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_players"))->setName('api.players');
    $this->post('/gangs', 'GangController:table')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_gangs"))->setName('api.gangs');

    $this->group("/player", function() {
        $container = $this->getContainer();
        //DataTables
        $this->post('/{id}/vehicles', 'VehicleController:vehicleTable')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_player_vehicles"))->setName('api.player.vehicles');
        $this->post('/{id}/notes', 'NoteController:playerNotes')->add(new HasPermissionAPIMiddleware($container, "can_view_player_notes"))->setName('api.player.notes');
        $this->post('/{id}/logs', 'LogController:playerEditLog')->add(new HasPermissionAPIMiddleware($container, "can_view_player_edit_log"))->setName('api.player.editLog');

        $this->post('/{id}/compensate', 'PlayerController:compensate')->add(new HasPermissionAPIMiddleware($container, "can_compensate"))->setName('api.player.compensate');
        $this->post('/{id}/license/{name}', 'PlayerController:updateLicense')->add(new HasPermissionAPIMiddleware($container, "can_edit_civ_lic"))->setName('api.player.license');
        $this->post('/{id}/addnote', 'NoteController:addNote')->add(new HasPermissionAPIMiddleware($container, "can_add_note"))->setName('api.player.addnote');
        $this->post('/{id}/arrested', 'PlayerController:updateArrestedState')->add(new HasPermissionAPIMiddleware($container, "can_edit_jailed"))->setName('api.player.arrested');
        $this->post('/{id}/admin', 'PlayerController:updateAdminRank')->add(new HasPermissionAPIMiddleware($container, "can_edit_admin_rank"))->setName('api.player.admin');
        $this->post('/{id}/donator', 'PlayerController:updateDonatorRank')->add(new HasPermissionAPIMiddleware($container, "can_edit_donator"))->setName('api.player.donator');
        $this->post('/{id}/bank', 'PlayerController:updateBank')->add(new HasPermissionAPIMiddleware($container, "can_edit_bank"))->setName('api.player.bank');
        $this->post('/{id}/cash', 'PlayerController:updateCash')->add(new HasPermissionAPIMiddleware($container, "can_edit_cash"))->setName('api.player.cash');
        $this->post('/{id}/cop', 'PlayerController:updateCopRank')->add(new HasPermissionAPIMiddleware($container, "can_edit_cop_rank"))->setName('api.player.cop');
        $this->post('/{id}/cop-license/{name}', 'PlayerController:updateLicense')->add(new HasPermissionAPIMiddleware($container, "can_edit_cop_lic"))->setName('api.player.license');
        $this->post('/{id}/medic', 'PlayerController:updateMedicRank')->add(new HasPermissionAPIMiddleware($container, "can_edit_ems_rank"))->setName('api.player.medic');
        $this->post('/{id}/ems-license/{name}', 'PlayerController:updateLicense')->add(new HasPermissionAPIMiddleware($container, "can_edit_ems_lic"))->setName('api.player.license');
    })->add(new PlayerIsValidAPIMiddleware($this->getContainer()))->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_player"));

    $this->post('/vehicles', 'VehicleController:table')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_view_vehicles"))->setName('api.vehicles');
    $this->post('/vehicle', 'VehicleController:updateVehicle')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_edit_vehicle"))->setName('api.vehicle.edit');

    $this->group("/note", function () {
        $this->post('/delete', 'NoteController:deleteNote')->add(new HasPermissionAPIMiddleware($this->getContainer(), "can_delete_note"))->setName('api.note.delete');
    });
})->add(new AuthenticatedMiddleware($app->getContainer()));

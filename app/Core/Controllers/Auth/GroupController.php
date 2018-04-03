<?php

namespace CyberWorks\Core\Controllers\Auth;

use CyberWorks\Core\Controllers\Controller;
use CyberWorks\Core\Models\Group;
use CyberWorks\Core\Helper\EditLogger;
use LiveControl\EloquentDataTable\DataTable;
use Respect\Validation\Validator as v;

class GroupController extends Controller
{
    public function index($request, $response) {
        return $this->view->render($response, 'groups/index.twig');
    }

    public function newView($request, $response) {
        return $this->view->render($response, 'groups/new.twig');
    }

    public function table($request, $response) {
        $groups = new Group();
        $table = new DataTable($groups, ['id', 'group_id', 'group_name', 'is_superUser']);

        $table->setFormatRowFunction(function ($group) {
            return [
                '<a href="group/' . $group->id . '"target="_blank">' . $group->group_name . '</a>',
                ($group->is_superUser == 1 ? "Yes" : "No"),
                '<a href="group/' . $group->id . '"target="_blank"><i class="fa fa-pencil"></i></a> <a onclick=\'showDeleteGroupBox('. $group->id .',"'. $group->group_name .'")\'><i class="fa fa-trash"></i></a>'
            ];
        });

        return $response->withJson($table->make());
    }

    public function group($request, $response, $args) {
        $group = Group::find($args['id']);

        $data = ['group' => $group];
        return $this->view->render($response, 'groups/group.twig', $data);
    }

    public function updateGroup($request, $response, $args) {
        $req_validation = $this->validator->validate($request, [
            'group_name' => v::notEmpty(),
            'is_superUser' => v::optional(v::optional(v::notEmpty())),
            'can_view_players' => v::optional(v::notEmpty()),
            'can_view_player' => v::optional(v::notEmpty()),
            'can_view_vehicles' => v::optional(v::notEmpty()),
            'can_view_vehicle' => v::optional(v::notEmpty()),
            'can_view_logs' => v::optional(v::notEmpty()),
            'can_view_player_civ_lic' => v::optional(v::notEmpty()),
            'can_view_player_cop_lic' => v::optional(v::notEmpty()),
            'can_view_player_ems_lic' => v::optional(v::notEmpty()),
            'can_view_player_notes' => v::optional(v::notEmpty()),
            'can_view_player_edit_log' => v::optional(v::notEmpty()),
            'can_view_player_vehicles' => v::optional(v::notEmpty()),
            'can_compensate' => v::optional(v::notEmpty()),
            'can_blacklist' => v::optional(v::notEmpty()),
            'can_add_note' => v::optional(v::notEmpty()),
            'can_delete_note' => v::optional(v::notEmpty()),
            'can_edit_cash' => v::optional(v::notEmpty()),
            'can_edit_bank' => v::optional(v::notEmpty()),
            'can_edit_donator' => v::optional(v::notEmpty()),
            'can_edit_jailed' => v::optional(v::notEmpty()),
            'can_edit_cop_rank' => v::optional(v::notEmpty()),
            'can_edit_cop_lic' => v::optional(v::notEmpty()),
            'can_edit_ems_rank' => v::optional(v::notEmpty()),
            'can_edit_ems_lic' => v::optional(v::notEmpty()),
            'can_edit_civ_lic' => v::optional(v::notEmpty()),
            'can_edit_admin_rank' => v::optional(v::notEmpty()),
            'can_edit_vehicle' => v::optional(v::notEmpty()),
            'can_view_gangs' => v::optional(v::notEmpty()),
            'can_edit_gang' => v::optional(v::notEmpty()),
            'can_edit_group_name' => v::optional(v::notEmpty()),
            'can_edit_group_perms' => v::optional(v::notEmpty()),
            'can_edit_group_perms_player' => v::optional(v::notEmpty()),
            'can_edit_group_perms_vehicle' => v::optional(v::notEmpty()),
            'can_edit_group_perms_settings' => v::optional(v::notEmpty()),
            'can_edit_group_perms_gang' => v::optional(v::notEmpty()),
            'can_edit_group_ips_id' => v::optional(v::notEmpty()),
            'can_make_groups' => v::optional(v::notEmpty()),
            'can_edit_users' => v::optional(v::notEmpty()),
            'can_add_user' => v::optional(v::notEmpty()),
            'can_del_user' => v::optional(v::notEmpty()),
            'can_edit_container' => v::optional(v::notEmpty()),
            'can_view_containers' => v::optional(v::notEmpty()),
            'can_edit_group_perms_container' => v::optional(v::notEmpty()),
            'can_edit_house' => v::optional(v::notEmpty()),
            'can_view_houses' => v::optional(v::notEmpty()),
            'can_edit_group_perms_house' => v::optional(v::notEmpty()),
            'can_del_group' => v::optional(v::notEmpty())
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        $group = Group::find($args['id']);

        if ($group->group_name != $request->getParam('group_name')) $group->group_name = $request->getParam('group_name');
        if ($this->container->config->get('useIps', false) && ($group->group_id != $request->getParam('group_id'))) $group->group_id = $request->getParam('group_id');
        if ($group->is_superUser != $this->convertCheckBox($request->getParam('is_superUser'))) $group->is_superUser = $this->convertCheckBox($request->getParam('is_superUser'));

        if ($group->can_view_players != $this->convertCheckBox($request->getParam('can_view_players'))) $group->can_view_players = $this->convertCheckBox($request->getParam('can_view_players'));
        if ($group->can_view_player != $this->convertCheckBox($request->getParam('can_view_player'))) $group->can_view_player = $this->convertCheckBox($request->getParam('can_view_player'));
        if ($group->can_view_vehicles != $this->convertCheckBox($request->getParam('can_view_vehicles'))) $group->can_view_vehicles = $this->convertCheckBox($request->getParam('can_view_vehicles'));
        if ($group->can_view_vehicle != $this->convertCheckBox($request->getParam('can_view_vehicle'))) $group->can_view_vehicle = $this->convertCheckBox($request->getParam('can_view_vehicle'));
        if ($group->can_view_logs != $this->convertCheckBox($request->getParam('can_view_logs'))) $group->can_view_logs = $this->convertCheckBox($request->getParam('can_view_logs'));
        if ($group->can_view_player_civ_lic != $this->convertCheckBox($request->getParam('can_view_player_civ_lic'))) $group->can_view_player_civ_lic = $this->convertCheckBox($request->getParam('can_view_player_civ_lic'));
        if ($group->can_view_player_cop_lic != $this->convertCheckBox($request->getParam('can_view_player_cop_lic'))) $group->can_view_player_cop_lic = $this->convertCheckBox($request->getParam('can_view_player_cop_lic'));
        if ($group->can_view_player_ems_lic != $this->convertCheckBox($request->getParam('can_view_player_ems_lic'))) $group->can_view_player_ems_lic = $this->convertCheckBox($request->getParam('can_view_player_ems_lic'));
        if ($group->can_view_player_notes != $this->convertCheckBox($request->getParam('can_view_player_notes'))) $group->can_view_player_notes = $this->convertCheckBox($request->getParam('can_view_player_notes'));
        if ($group->can_view_player_edit_log != $this->convertCheckBox($request->getParam('can_view_player_edit_log'))) $group->can_view_player_edit_log = $this->convertCheckBox($request->getParam('can_view_player_edit_log'));
        if ($group->can_view_player_vehicles != $this->convertCheckBox($request->getParam('can_view_player_vehicles'))) $group->can_view_player_vehicles = $this->convertCheckBox($request->getParam('can_view_player_vehicles'));
        if ($group->can_view_gangs != $this->convertCheckBox($request->getParam('can_view_gangs'))) $group->can_view_gangs = $this->convertCheckBox($request->getParam('can_view_gangs'));

        if ($group->can_compensate != $this->convertCheckBox($request->getParam('can_compensate'))) $group->can_compensate = $this->convertCheckBox($request->getParam('can_compensate'));
        if ($group->can_blacklist != $this->convertCheckBox($request->getParam('can_blacklist'))) $group->can_blacklist = $this->convertCheckBox($request->getParam('can_blacklist'));
        if ($group->can_add_note != $this->convertCheckBox($request->getParam('can_add_note'))) $group->can_add_note = $this->convertCheckBox($request->getParam('can_add_note'));
        if ($group->can_delete_note != $this->convertCheckBox($request->getParam('can_delete_note'))) $group->can_delete_note = $this->convertCheckBox($request->getParam('can_delete_note'));
        if ($group->can_edit_cash != $this->convertCheckBox($request->getParam('can_edit_cash'))) $group->can_edit_cash = $this->convertCheckBox($request->getParam('can_edit_cash'));
        if ($group->can_edit_bank != $this->convertCheckBox($request->getParam('can_edit_bank'))) $group->can_edit_bank = $this->convertCheckBox($request->getParam('can_edit_bank'));
        if ($group->can_edit_donator != $this->convertCheckBox($request->getParam('can_edit_donator'))) $group->can_edit_donator = $this->convertCheckBox($request->getParam('can_edit_donator'));
        if ($group->can_edit_jailed != $this->convertCheckBox($request->getParam('can_edit_jailed'))) $group->can_edit_jailed = $this->convertCheckBox($request->getParam('can_edit_jailed'));
        if ($group->can_edit_cop_rank != $this->convertCheckBox($request->getParam('can_edit_cop_rank'))) $group->can_edit_cop_rank = $this->convertCheckBox($request->getParam('can_edit_cop_rank'));
        if ($group->can_edit_cop_lic != $this->convertCheckBox($request->getParam('can_edit_cop_lic'))) $group->can_edit_cop_lic = $this->convertCheckBox($request->getParam('can_edit_cop_lic'));
        if ($group->can_edit_ems_rank != $this->convertCheckBox($request->getParam('can_edit_ems_rank'))) $group->can_edit_ems_rank = $this->convertCheckBox($request->getParam('can_edit_ems_rank'));
        if ($group->can_edit_ems_lic != $this->convertCheckBox($request->getParam('can_edit_ems_lic'))) $group->can_edit_ems_lic = $this->convertCheckBox($request->getParam('can_edit_ems_lic'));
        if ($group->can_edit_civ_lic != $this->convertCheckBox($request->getParam('can_edit_civ_lic'))) $group->can_edit_civ_lic = $this->convertCheckBox($request->getParam('can_edit_civ_lic'));
        if ($group->can_edit_admin_rank != $this->convertCheckBox($request->getParam('can_edit_admin_rank'))) $group->can_edit_admin_rank = $this->convertCheckBox($request->getParam('can_edit_admin_rank'));
        if ($group->can_edit_vehicle != $this->convertCheckBox($request->getParam('can_edit_vehicle'))) $group->can_edit_vehicle = $this->convertCheckBox($request->getParam('can_edit_vehicle'));
        if ($group->can_edit_gang != $this->convertCheckBox($request->getParam('can_edit_gang'))) $group->can_edit_gang = $this->convertCheckBox($request->getParam('can_edit_gang'));
        if ($group->can_edit_container != $this->convertCheckBox($request->getParam('can_edit_container'))) $group->can_edit_container = $this->convertCheckBox($request->getParam('can_edit_container'));
        if ($group->can_view_containers != $this->convertCheckBox($request->getParam('can_view_containers'))) $group->can_del_user = $this->convertCheckBox($request->getParam('can_view_containers'));
        if ($group->can_edit_house != $this->convertCheckBox($request->getParam('can_edit_house'))) $group->can_edit_house = $this->convertCheckBox($request->getParam('can_edit_house'));
        if ($group->can_view_houses != $this->convertCheckBox($request->getParam('can_view_houses'))) $group->can_view_houses = $this->convertCheckBox($request->getParam('can_view_houses'));

        if ($group->can_edit_group_name != $this->convertCheckBox($request->getParam('can_edit_group_name'))) $group->can_edit_group_name = $this->convertCheckBox($request->getParam('can_edit_group_name'));
        if ($group->can_edit_group_perms != $this->convertCheckBox($request->getParam('can_edit_group_perms'))) $group->can_edit_group_perms = $this->convertCheckBox($request->getParam('can_edit_group_perms'));
        if ($group->can_edit_group_perms_player != $this->convertCheckBox($request->getParam('can_edit_group_perms_player'))) $group->can_edit_group_perms_player = $this->convertCheckBox($request->getParam('can_edit_group_perms_player'));
        if ($group->can_edit_group_perms_container != $this->convertCheckBox($request->getParam('can_edit_group_perms_container'))) $group->can_edit_group_perms_container = $this->convertCheckBox($request->getParam('can_edit_group_perms_container'));
        if ($group->can_edit_group_perms_vehicle != $this->convertCheckBox($request->getParam('can_edit_group_perms_vehicle'))) $group->can_edit_group_perms_vehicle = $this->convertCheckBox($request->getParam('can_edit_group_perms_vehicle'));
        if ($group->can_edit_group_perms_settings != $this->convertCheckBox($request->getParam('can_edit_group_perms_settings'))) $group->can_edit_group_perms_settings = $this->convertCheckBox($request->getParam('can_edit_group_perms_settings'));
        if ($group->can_edit_group_ips_id != $this->convertCheckBox($request->getParam('can_edit_group_ips_id'))) $group->can_edit_group_ips_id = $this->convertCheckBox($request->getParam('can_edit_group_ips_id'));
        if ($group->can_make_groups != $this->convertCheckBox($request->getParam('can_make_groups'))) $group->can_make_groups = $this->convertCheckBox($request->getParam('can_make_groups'));
        if ($group->can_edit_group_perms_gang != $this->convertCheckBox($request->getParam('can_edit_group_perms_gang'))) $group->can_edit_group_perms_gang = $this->convertCheckBox($request->getParam('can_edit_group_perms_gang'));
        if ($group->can_edit_group_perms_house != $this->convertCheckBox($request->getParam('can_edit_group_perms_house'))) $group->can_edit_group_perms_house = $this->convertCheckBox($request->getParam('can_edit_group_perms_house'));


        if ($group->can_edit_users != $this->convertCheckBox($request->getParam('can_edit_users'))) $group->can_edit_users = $this->convertCheckBox($request->getParam('can_edit_users'));
        if ($group->can_add_user != $this->convertCheckBox($request->getParam('can_add_user'))) $group->can_add_user = $this->convertCheckBox($request->getParam('can_add_user'));
        if ($group->can_del_user != $this->convertCheckBox($request->getParam('can_del_user'))) $group->can_del_user = $this->convertCheckBox($request->getParam('can_del_user'));
        if ($group->can_del_group != $this->convertCheckBox($request->getParam('can_del_group'))) $group->can_del_group = $this->convertCheckBox($request->getParam('can_del_group'));

        if ($group->isDirty()) {
            $this->container->logger->info("Group: " + $group->id + " Was updated By User:" + $_SESSION['user_id']);
            $group->save();
        }

        EditLogger::logEdit('6', "Updated Group ". $group->id ." ". $group->group_name);

        return $response->withRedirect($this->router->pathFor('groups'));
    }

    public function newGroup($request, $response) {
        $req_validation = $this->validator->validate($request, [
            'group_name' => v::notEmpty(),
            'is_superUser' => v::optional(v::optional(v::notEmpty())),
            'can_view_players' => v::optional(v::notEmpty()),
            'can_view_player' => v::optional(v::notEmpty()),
            'can_view_vehicles' => v::optional(v::notEmpty()),
            'can_view_vehicle' => v::optional(v::notEmpty()),
            'can_view_logs' => v::optional(v::notEmpty()),
            'can_view_player_civ_lic' => v::optional(v::notEmpty()),
            'can_view_player_cop_lic' => v::optional(v::notEmpty()),
            'can_view_player_ems_lic' => v::optional(v::notEmpty()),
            'can_view_player_notes' => v::optional(v::notEmpty()),
            'can_view_player_edit_log' => v::optional(v::notEmpty()),
            'can_view_player_vehicles' => v::optional(v::notEmpty()),
            'can_compensate' => v::optional(v::notEmpty()),
            'can_blacklist' => v::optional(v::notEmpty()),
            'can_add_note' => v::optional(v::notEmpty()),
            'can_delete_note' => v::optional(v::notEmpty()),
            'can_edit_cash' => v::optional(v::notEmpty()),
            'can_edit_bank' => v::optional(v::notEmpty()),
            'can_edit_donator' => v::optional(v::notEmpty()),
            'can_edit_jailed' => v::optional(v::notEmpty()),
            'can_edit_cop_rank' => v::optional(v::notEmpty()),
            'can_edit_cop_lic' => v::optional(v::notEmpty()),
            'can_edit_ems_rank' => v::optional(v::notEmpty()),
            'can_edit_ems_lic' => v::optional(v::notEmpty()),
            'can_edit_civ_lic' => v::optional(v::notEmpty()),
            'can_edit_admin_rank' => v::optional(v::notEmpty()),
            'can_edit_vehicle' => v::optional(v::notEmpty()),
            'can_view_gangs' => v::optional(v::notEmpty()),
            'can_edit_gang' => v::optional(v::notEmpty()),
            'can_edit_group_name' => v::optional(v::notEmpty()),
            'can_edit_group_perms' => v::optional(v::notEmpty()),
            'can_edit_group_perms_player' => v::optional(v::notEmpty()),
            'can_edit_group_perms_vehicle' => v::optional(v::notEmpty()),
            'can_edit_group_perms_settings' => v::optional(v::notEmpty()),
            'can_edit_group_perms_gang' => v::optional(v::notEmpty()),
            'can_edit_group_ips_id' => v::optional(v::notEmpty()),
            'can_make_groups' => v::optional(v::notEmpty()),
            'can_edit_users' => v::optional(v::notEmpty()),
            'can_add_user' => v::optional(v::notEmpty()),
            'can_del_user' => v::optional(v::notEmpty()),
            'can_edit_container' => v::optional(v::notEmpty()),
            'can_view_containers' => v::optional(v::notEmpty()),
            'can_edit_group_perms_container' => v::optional(v::notEmpty()),
            'can_edit_house' => v::optional(v::notEmpty()),
            'can_view_houses' => v::optional(v::notEmpty()),
            'can_edit_group_perms_house' => v::optional(v::notEmpty()),
            'can_del_group' => v::optional(v::notEmpty())
        ]);

        if ($req_validation->failed()) {
            $this->container->alerts->addMessage("error", "Group Name Not Set");
            return $response->withRedirect($this->container->router->pathFor('group.new'));
        }

        $group = new Group();

        $group->group_name = $request->getParam('group_name');
        $group->group_id = null; //Temp
        $group->save(); //Do this so we can get an id for the group.

        if ($this->container->config->get('useIps', false)) {
            $group->group_id = $request->getParam('group_id');
        }

        $group->is_superUser = $this->convertCheckBox($request->getParam('is_superUser'));

        $group->can_view_players = $this->convertCheckBox($request->getParam('can_view_players'));
        $group->can_view_player = $this->convertCheckBox($request->getParam('can_view_player'));
        $group->can_view_vehicles = $this->convertCheckBox($request->getParam('can_view_vehicles'));
        $group->can_view_vehicle = $this->convertCheckBox($request->getParam('can_view_vehicle'));
        $group->can_view_logs = $this->convertCheckBox($request->getParam('can_view_logs'));
        $group->can_view_player_civ_lic = $this->convertCheckBox($request->getParam('can_view_player_civ_lic'));
        $group->can_view_player_cop_lic = $this->convertCheckBox($request->getParam('can_view_player_cop_lic'));
        $group->can_view_player_ems_lic = $this->convertCheckBox($request->getParam('can_view_player_ems_lic'));
        $group->can_view_player_notes = $this->convertCheckBox($request->getParam('can_view_player_notes'));
        $group->can_view_player_edit_log = $this->convertCheckBox($request->getParam('can_view_player_edit_log'));
        $group->can_view_player_vehicles = $this->convertCheckBox($request->getParam('can_view_player_vehicles'));
        $group->can_view_gangs = $this->convertCheckBox($request->getParam('can_view_gangs'));

        $group->can_compensate = $this->convertCheckBox($request->getParam('can_compensate'));
        $group->can_blacklist = $this->convertCheckBox($request->getParam('can_blacklist'));
        $group->can_add_note = $this->convertCheckBox($request->getParam('can_add_note'));
        $group->can_delete_note = $this->convertCheckBox($request->getParam('can_delete_note'));
        $group->can_edit_cash = $this->convertCheckBox($request->getParam('can_edit_cash'));
        $group->can_edit_bank = $this->convertCheckBox($request->getParam('can_edit_bank'));
        $group->can_edit_donator = $this->convertCheckBox($request->getParam('can_edit_donator'));
        $group->can_edit_jailed = $this->convertCheckBox($request->getParam('can_edit_jailed'));
        $group->can_edit_cop_rank = $this->convertCheckBox($request->getParam('can_edit_cop_rank'));
        $group->can_edit_cop_lic = $this->convertCheckBox($request->getParam('can_edit_cop_lic'));
        $group->can_edit_ems_rank = $this->convertCheckBox($request->getParam('can_edit_ems_rank'));
        $group->can_edit_ems_lic = $this->convertCheckBox($request->getParam('can_edit_ems_lic'));
        $group->can_edit_civ_lic = $this->convertCheckBox($request->getParam('can_edit_civ_lic'));
        $group->can_edit_admin_rank = $this->convertCheckBox($request->getParam('can_edit_admin_rank'));
        $group->can_edit_vehicle = $this->convertCheckBox($request->getParam('can_edit_vehicle'));
        $group->can_edit_gang = $this->convertCheckBox($request->getParam('can_edit_gang'));
        $group->can_edit_container = $this->convertCheckBox($request->getParam('can_edit_container'));
        $group->can_del_user = $this->convertCheckBox($request->getParam('can_view_containers'));
        $group->can_edit_house = $this->convertCheckBox($request->getParam('can_edit_house'));
        $group->can_view_houses = $this->convertCheckBox($request->getParam('can_view_houses'));

        $group->can_edit_group_name = $this->convertCheckBox($request->getParam('can_edit_group_name'));
        $group->can_edit_group_perms = $this->convertCheckBox($request->getParam('can_edit_group_perms'));
        $group->can_edit_group_perms_player = $this->convertCheckBox($request->getParam('can_edit_group_perms_player'));
        $group->can_edit_group_perms_container = $this->convertCheckBox($request->getParam('can_edit_group_perms_container'));
        $group->can_edit_group_perms_vehicle = $this->convertCheckBox($request->getParam('can_edit_group_perms_vehicle'));
        $group->can_edit_group_perms_settings = $this->convertCheckBox($request->getParam('can_edit_group_perms_settings'));
        $group->can_edit_group_ips_id = $this->convertCheckBox($request->getParam('can_edit_group_ips_id'));
        $group->can_make_groups = $this->convertCheckBox($request->getParam('can_make_groups'));
        $group->can_edit_group_perms_gang = $this->convertCheckBox($request->getParam('can_edit_group_perms_gang'));
        $group->can_edit_group_perms_house = $this->convertCheckBox($request->getParam('can_edit_group_perms_house'));

        $group->can_edit_users = $this->convertCheckBox($request->getParam('can_edit_users'));
        $group->can_add_user = $this->convertCheckBox($request->getParam('can_add_user'));
        $group->can_del_user = $this->convertCheckBox($request->getParam('can_del_user'));
        $group->can_del_group = $this->convertCheckBox($request->getParam('can_del_group'));

        $this->container->logger->info("Group: " + $group->id + " Was Added By User:" + $_SESSION['user_id']);
        $group->save();

        EditLogger::logEdit('6', "Added Group ". $group->id ." ". $group->group_name);

        return $response->withRedirect($this->router->pathFor('groups'));
    }

    public function convertCheckBox($input) {
        return ($input == 'on' ? 1 : 0);
    }

    public function deleteGroup($request, $response) {
        $req_validation = $this->validator->validate($request, [
            'id' => v::notEmpty()
        ]);

        if ($req_validation->failed()) {
            return $response->withJson(['error' => 'Validation Failed', 'errors' => $req_validation->errors()], 400);
        }

        if ($request->getParam('id') == 1) {
            return $response->withJson(['error' => 'Can Not Remove Default Group!'], 400);
        }

        $group = Group::find($request->getParam('id'));

        EditLogger::logEdit('6', "Deleted Group ". $group->group_name ." ". $request->getParam('id'));

        $group->delete();

        return $response->withStatus(200);
    }
}

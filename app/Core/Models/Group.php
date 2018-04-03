<?php

namespace CyberWorks\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'cw_permissions';

    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'group_name',
        'group_id',
        'is_superUser',
        'can_view_players',
        'can_view_player',
        'can_view_vehicles',
        'can_view_vehicle',
        'can_view_logs',
        'can_view_player_civ_lic',
        'can_view_player_cop_lic',
        'can_view_player_ems_lic',
        'can_view_player_notes',
        'can_view_player_edit_log',
        'can_view_player_vehicles',
        'can_compensate',
        'can_blacklist',
        'can_add_note',
        'can_delete_note',
        'can_edit_cash',
        'can_edit_bank',
        'can_edit_donator',
        'can_edit_jailed',
        'can_edit_cop_rank',
        'can_edit_cop_lic',
        'can_edit_ems_rank',
        'can_edit_ems_lic',
        'can_edit_civ_lic',
        'can_edit_admin_rank',
        'can_edit_vehicle',
        'can_view_gangs',
        'can_edit_gang',
        'can_edit_group_name',
        'can_edit_group_perms',
        'can_edit_group_perms_player',
        'can_edit_group_perms_vehicle',
        'can_edit_group_perms_settings',
        'can_edit_group_perms_gang',
        'can_edit_group_ips_id',
        'can_make_groups',
        'can_edit_users',
        'can_add_user',
        'can_del_user',
        'can_edit_container',
        'can_view_containers',
        'can_del_group'
    ];
}
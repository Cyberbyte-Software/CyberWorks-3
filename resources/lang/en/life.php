<?php
return array (
    'title' => 'Life',
    'generic' => array (
        'name' => 'Name',
        'bank' => 'Bank',
        'cash' => 'Cash',
        'pid' => 'Player ID',
        'cRank' => 'Cop Rank',
        'mRank' => 'Medic Rank',
        'aRank' => 'Admin Rank',
        'civ' => 'Civ',
        'cop' => 'Cop',
        'med' => 'Medic',
        'admin' => 'Admin',
        'type' => 'Type',
        'owner' => 'Owner',
        'vItems' => 'Virtual Items',
        'inventory' => 'Inventory',
        'pos' => 'Position',
        'edit' => 'Edit',
    ),
    'player' => array (
        'title' => 'Player',
        'tiles' => array (
            'bank' => array (
                'title' => 'Bank Account',
                'desc' => 'Total Funds In Bank',
            ),
            'cash' => array (
                'desc' => 'Total Funds In Hand',
            ),
            'admin' => array (
                'desc' => 'Admin Level In Game',
            ),
            'cop' => array (
                'desc' => 'Rank In The Police Force',
            ),
            'medic' => array (
                'desc' => 'Rank In The Fire Department',
            ),
        ),
        'steam' => array (
            'profile' => 'Steam Profile',
            'id' => 'SteamID',
        ),
        'buttons' => array (
            'compensate' => 'Compenstae',
            'addNote' => 'Add Note',
        ),
        'tabs' => array (
            'lic' => array (
                'civ' => 'Civ Licenses',
                'cop' => 'Cop Licenses',
                'med' => 'Medic Licenses',
            ),
            'veh' => 'Vehicles',
            'notes' => 'Notes',
            'eLog' => 'Edit Log',
        ),
        'modals' => array(
            'compensate' => array(
                'title' =>  'Ammount To Compensate'
            ),
        ),
        'guid' => 'GUID',
        'donator' => 'Donator',
        'jailed' => 'jailed'
    ),
    'players' => array (
        'title' => 'Players',
        'actions' => 'Actions',
    ),
    'vehicles' => array (
        'title' => 'Vehicles',
        'titleSingle' => 'Vehicle',
        'id' => 'Vehicle ID',
        'class' => 'Vehicle Class',
        'side' => 'Side',
        'alive' => 'Alive',
        'active' => 'Active',
        'plate' => 'Plate',
        'color' => 'Color',
        'garage' => 'In Garage',
        'update' => 'Update Vehicle',
        'refule' => 'Refule',
        'repair' => 'Repair',
    ),
    'houses' => array (
        'title' => 'Houses',
        'titleSingle' => 'House',
        'id' => 'House ID',
        'update' => 'Update House'
    ),
    'gangs' => array (
        'title' => 'Gangs',
        'titleSingle' => 'Gang',
        'maxMem' => 'Max Members',
        'mem' => 'Members',
        'update' => 'Update Gang',
        'funds' => 'Funds',
    ),
    'containers' => array (
        'title' => 'Containers',
        'titleSingle' => 'Container',
        'id' => 'Container ID',
        'class' => 'Classname',
        'dir' => 'Dir',
        'update' => 'Update Container',
    ),
    'perms' => array(
        'view' => 'View',
        'edit' => 'Edit',
        'admin' => 'Admin',
        'player' => array(
            'view' => array(
                'player' => 'View Player',
                'players' => 'View Players',
                'notes' => 'View Player Notes',
                'civLic' => 'View Player Civ Lic',
                'copLic' => 'View Player Cop Lic',
                'medLic' => 'View Player Med Lic',
                'editLog' => 'View Player Edit Log',
                'veh' => 'View Player Vehicles',
            ),
            'edit' => array(
                'cash' => 'Edit Cash',
                'bank' => 'Edit Bank',
                'donator' => 'Edit Donator',
                'jailed' => 'Edit Jailed',
                'civLic' => 'Edit Civ Lic',
                'copLic' => 'Edit Cop Lic',
                'medLic' => 'Edit Med Lic',
                'cRank' => 'Edit Cop Rank',
                'mRank' => 'Edit Medic Rank'
            ),
            'admin' => array(
                'aRank' => 'Edit Admin Rank',
                'blacklist' => 'Blacklist',
                'comp' => 'Compensate',
                'addNote' => 'Add Note',
                'delNote' => 'Delete Note',
            ),
        ),
        'veh' => array(
            'view' => array(
                'vehicle' => 'View Vehicle',
                'vehicles' => 'View Vehicles',
            ),
            'edit' => 'Edit Vehicle',
        ),
        'gang' => array(
            'view' => 'View Gangs',
            'edit' => 'Edit Gangs',
        ),
        'house' => array(
            'view' => 'View Houses',
            'edit' => 'Edit Houses'
        ),
        'container' => array(
            'view' => 'View Containers',
            'edit' => 'Edit Containers',
        ),
    ),
);
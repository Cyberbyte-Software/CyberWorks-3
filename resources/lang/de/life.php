<?php
return array (
    'title' => 'Life',
    'generic' => array (
        'name' => 'Name',
        'bank' => 'Konto',
        'cash' => 'Bargeld',
        'pid' => 'Player ID',
        'cRank' => 'Polizei Rang',
        'mRank' => 'Feuerwehr Rang',
        'aRank' => 'Admin Level',
        'civ' => 'Zivilist',
        'cop' => 'Polizei',
        'med' => 'F.W.A',
        'admin' => 'Admin',
        'type' => 'Typ',
        'owner' => 'Besitzer',
        'vItems' => 'Virtuelle Items',
        'inventory' => 'Inventar',
        'pos' => 'Position',
        'edit' => 'Bearbeiten',
    ),
    'lic' => array (
        'license_civ_driver' => 'Drivers License',
        'license_civ_boat' => 'Boating License',
        'license_civ_pilot' => 'Pilots License',
        'license_civ_gun' => 'Firearm License',
        'license_civ_dive' => 'Diving License',
        'license_civ_oil' => 'Oil Processing',
        'license_civ_heroin' => 'Processing Heroin',
        'license_civ_marijuana' => 'Processing Marijuana',
        'license_civ_rebel' => 'Rebel Training',
        'license_civ_trucking' => 'Truck License',
        'license_civ_diamond' => 'Diamond Processing',
        'license_civ_salt' => 'Salt Processing',
        'license_civ_cocaine' => 'Cocaine Processing',
        'license_civ_sand' => 'Sand Processing',
        'license_civ_iron' => 'Iron Processing',
        'license_civ_copper' => 'Copper Processing',
        'license_civ_cement' => 'Cement Mixing License',
        'license_civ_home' => 'Home Owners License',
        'license_civ_truck' => 'Truck License',
        'license_cop_cAir' => 'Pilots License',
        'license_cop_coastguard' => 'Coast Guard License',
        'license_cop_swat' => 'SWAT License',
        'license_med_mAir' => 'Pilots License',
    ),
    'player' => array (
        'title' => 'Spieler',
        'tiles' => array (
            'bank' => array (
                'title' => 'Kontostand',
                'desc' => 'Kontostand des Spielers',
            ),
            'cash' => array (
                'desc' => 'Bargeld auf der Hand',
            ),
            'admin' => array (
                'desc' => 'Admin Level',
            ),
            'cop' => array (
                'desc' => 'Rang in der Polizei',
            ),
            'medic' => array (
                'desc' => 'Rang in der Feuerwehr',
            ),
        ),
        'steam' => array (
            'profile' => 'Steam Profil',
            'id' => 'SteamID',
        ),
        'buttons' => array (
            'compensate' => 'Geld Erstatten',
            'addNote' => 'Notiz hinzufügen',
        ),
        'tabs' => array (
            'lic' => array (
                'civ' => 'Zivil Lizenzen',
                'cop' => 'Polizei Lizenzen',
                'med' => 'Feuerwehr Lizenzen',
            ),
            'veh' => 'Fahrzeuge',
            'notes' => 'Notizen',
            'eLog' => 'Bearbeitung',
        ),
        'modals' => array(
            'compensate' => array(
                'title' =>  'Betrag'
            ),
        ),
        'guid' => 'GUID',
        'donator' => 'Spender',
        'jailed' => 'Knast'
    ),
    'players' => array (
        'title' => 'Spieler',
        'actions' => 'Aktionen',
    ),
    'vehicles' => array (
        'title' => 'Fahrzeuge',
        'titleSingle' => 'Fahrzeug',
        'id' => 'Fahrzeug ID',
        'class' => 'Fahrzeug Class',
        'side' => 'Fraktion',
        'alive' => 'Am Leben',
        'active' => 'Aktiv',
        'plate' => 'Kennzeichen',
        'color' => 'Skin',
        'garage' => 'In Garage',
        'update' => 'Übernehmen',
        'refule' => 'Auftanken',
        'repair' => 'Reparieren',
    ),
    'houses' => array (
        'title' => 'Häuser',
        'titleSingle' => 'Haus',
        'id' => 'Haus ID',
        'update' => 'Übernehmen'
    ),
    'gangs' => array (
        'title' => 'Gangs',
        'titleSingle' => 'Gang',
        'maxMem' => 'Max Mitglieder',
        'mem' => 'Member',
        'update' => 'Übernehmen',
        'funds' => 'Gangkonto',
    ),
    'containers' => array (
        'title' => 'Container',
        'titleSingle' => 'Container',
        'id' => 'Container ID',
        'class' => 'Classname',
        'dir' => 'Dir',
        'update' => 'Übernehmen',
    ),
    'perms' => array(
        'view' => 'Sehen',
        'edit' => 'Bearbeiten',
        'admin' => 'Admin',
        'player' => array(
            'view' => array(
                'player' => 'Spieler Sehen',
                'players' => 'Spielerliste Sehen',
                'notes' => 'Spieler Notizen sehen',
                'civLic' => 'Zivil Lizenzen sehen',
                'copLic' => 'Polizei Lizenzen sehen',
                'medLic' => 'Feuerwehr Lizenzen sehen',
                'editLog' => 'Bearbeitung sehen',
                'veh' => 'Spieler Fahrzeuge sehen',
            ),
            'edit' => array(
                'cash' => 'Bargeld bearbeiten',
                'bank' => 'Konto bearbeiten',
                'donator' => 'Spenderlevel vergeben',
                'jailed' => 'Knaststatus bearbeiten',
                'civLic' => 'Zivil Lizenzen bearbeiten',
                'copLic' => 'Polizei Lizenzen bearbeiten',
                'medLic' => 'Feuerwehr Lizenzen bearbeiten',
                'cRank' => 'Polizei Rank vergeben',
                'mRank' => 'Feuerwehr Rang vergeben'
            ),
            'admin' => array(
                'aRank' => 'Admin Level vergeben',
                'blacklist' => 'Blacklist',
                'comp' => 'Erstatten',
                'addNote' => 'Notiz hinzufügen',
                'delNote' => 'Notiz löschen',
            ),
        ),
        'veh' => array(
            'view' => array(
                'vehicle' => 'Fahrzeug Sehen',
                'vehicles' => 'Fahrzeugliste Sehen',
            ),
            'edit' => 'Fahrzeug bearbeiten',
        ),
        'gang' => array(
            'view' => 'Gangs Sehen',
            'edit' => 'Gangs bearbeiten',
        ),
        'house' => array(
            'view' => 'Häuser Sehen',
            'edit' => 'Häuser bearbeiten'
        ),
        'container' => array(
            'view' => 'Container Sehen',
            'edit' => 'Container bearbeiten',
        ),
    ),
);

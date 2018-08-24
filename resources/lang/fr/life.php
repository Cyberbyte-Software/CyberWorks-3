<?php
return array (
    'title' => 'Life',
    'generic' => array (
        'name' => 'Nom',
        'bank' => 'Banque',
        'cash' => 'Cash',
        'pid' => 'Player ID',
        'cRank' => 'Rang BLUFOR',
        'mRank' => 'Rang INDEP',
        'aRank' => 'Rang Admin',
        'civ' => 'Civil',
        'cop' => 'BLUFOR',
        'med' => 'INDEP',
        'admin' => 'Admin',
        'type' => 'Type',
        'owner' => 'Propriétaire',
        'vItems' => 'Objets virtuels',
        'inventory' => 'Inventaire',
        'pos' => 'Position',
        'edit' => 'Editer',
    ),
    'lic' => array (
        'license_civ_driver' => 'Permis de conduire',
        'license_civ_boat' => 'Permis bateau',
        'license_civ_pilot' => 'Permis aérien',
        'license_civ_gun' => 'Permis port arme',
        'license_civ_truck' => 'Permis Poids-Lourds',
        'license_civ_salt' => 'Traitement de sel',
        'license_civ_oil' => 'Traitement d huile',
        'license_civ_heroin' => 'Traitement Heroin',
        'license_civ_marijuana' => 'Traitement Marijuana',
        'license_civ_rebel' => 'Entrainement rebelle',
        'license_civ_diamond' => 'Traitement de Diamant',
        'license_civ_cocaine' => 'Traitement Cocaine',
        'license_civ_home' => 'Droit de propriétée',
        'license_cop_cAir' => 'Formation pilote',
        'license_cop_coastguard' => 'Formation garde-cotes',
        'license_cop_swat' => 'Formation GIGN',
        'license_med_mAir' => 'Formation ASU',
    ),
    'player' => array (
        'title' => 'Joueur',
        'tiles' => array (
            'bank' => array (
                'title' => 'Compte en banque',
                'desc' => 'Fonds totaux en banque',
            ),
            'cash' => array (
                'desc' => 'Fonds totaux en cash',
            ),
            'admin' => array (
                'desc' => 'Niveau Admin IG',
            ),
            'cop' => array (
                'desc' => 'Rank BLUFOR',
            ),
            'medic' => array (
                'desc' => 'Rang INDEP',
            ),
        ),
        'steam' => array (
            'profile' => 'Profil Steam',
            'id' => 'Steam ID',
        ),
        'buttons' => array (
            'compensate' => 'Rembourser',
            'changename' => 'Changer le nom - WIP',
            'addNote' => 'Ajouter une Note',
        ),
        'tabs' => array (
            'lic' => array (
                'civ' => 'Licenses Civiles',
                'cop' => 'Licenses BLUFOR',
                'med' => 'Licenses INDEP',
            ),
            'veh' => 'Vehicules',
            'notes' => 'Notes',
            'eLog' => 'Editer Log',
        ),
        'modals' => array(
            'compensate' => array(
                'title' =>  'Montant à rembourser'
            ),
        ),
        'guid' => 'GUID',
        'donator' => 'Donateur',
        'jailed' => 'Prisonnier'
    ),
    'players' => array (
        'title' => 'Joueurs',
        'actions' => 'Actions',
    ),
    'vehicles' => array (
        'title' => 'Vehicules',
        'titleSingle' => 'Vehicule',
        'id' => 'Vehicule ID',
        'class' => 'Classe Vehicule',
        'side' => 'Side',
        'alive' => 'En vie',
        'active' => 'Actif',
        'plate' => 'Plaque',
        'color' => 'Couleur',
        'garage' => 'Dans le garage',
        'update' => 'Mise à jour véhicule',
        'refule' => 'Ravitailler',
        'repair' => 'Reparer',
    ),
    'houses' => array (
        'title' => 'Maisons',
        'titleSingle' => 'Maison',
        'id' => 'ID Maison',
        'update' => 'Mise à jour Maison'
    ),
    'gangs' => array (
        'title' => 'Gangs',
        'titleSingle' => 'Gang',
        'maxMem' => 'Max Membres',
        'mem' => 'Membres',
        'update' => 'Mise à jour gang',
        'funds' => 'Fonds',
    ),
    'containers' => array (
        'title' => 'Coffres',
        'titleSingle' => 'Coffre',
        'id' => 'ID Coffre',
        'class' => 'Classname',
        'dir' => 'dir',
        'update' => 'Mise à jour coffre',
    ),
    'perms' => array(
        'view' => 'Regarder',
        'edit' => 'Editer',
        'admin' => 'Admin',
        'player' => array(
            'view' => array(
                'player' => 'Regarder Joueur',
                'players' => 'Regarder Joueurs',
                'notes' => 'Regarder Notes du Joueur',
                'civLic' => 'Regarder Licences Civiles du joueur',
                'copLic' => 'Regarder Licences BLUFOR du joueur',
                'medLic' => 'Regarder Licences INDEP du joueur',
                'editLog' => 'Regarder les logs de d edition du joueur',
                'veh' => 'Regarder les vehicules du joueur',
            ),
            'edit' => array(
                'cash' => 'Editer Cash',
                'bank' => 'Editer Banque',
                'donator' => 'Editer Donateur',
                'jailed' => 'Editer Prisonnier',
                'civLic' => 'Editer Licences Civiles',
                'copLic' => 'Editer Licences BLUFOR',
                'medLic' => 'Editer Licences INDEP',
                'cRank' => 'Editer Rang BLUFOR',
                'mRank' => 'Editer Rang INDEP'
            ),
            'admin' => array(
                'aRank' => 'Editer Rang Admin',
                'blacklist' => 'Blacklist',
                'comp' => 'Compensez',
                'addNote' => 'Ajouter Note',
                'delNote' => 'Supprimer Note',
            ),
        ),
        'veh' => array(
            'view' => array(
                'vehicle' => 'Regarder Vehicule',
                'vehicles' => 'Regarder Vehicules',
            ),
            'edit' => 'Edit Vehicule',
        ),
        'gang' => array(
            'view' => 'Regarder Gangs',
            'edit' => 'Editer Gangs',
        ),
        'house' => array(
            'view' => 'Regarder Maisons',
            'edit' => 'Editer Maisons'
        ),
        'container' => array(
            'view' => 'Regarder Coffres',
            'edit' => 'Editer Coffres',
        ),
    ),
);
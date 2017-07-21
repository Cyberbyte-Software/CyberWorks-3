<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 15/06/2017
 * Time: 13:45
 */
if (file_exists(__DIR__. '/../config/config.php')) {
    die('Config Already Exists');
}

if (isset($_POST['db_host']) && isset($_POST['db_port']) && isset($_POST['db_user']) && isset($_POST['db_password']) && isset($_POST['db_db'])) {

    function checkConnection($host, $port, $db, $user, $password) {
        try {
            $connection = new PDO("mysql:host=".$host.";dbname=".$db.";port=".$port.";charset=utf8", $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            return $connection;
        } catch (PDOException $ex) {
            die("Unable to connect: ". $ex->getMessage());
        }
    }

    $connection = checkConnection($_POST['db_host'], $_POST['db_port'], $_POST['db_db'], $_POST['db_user'], $_POST['db_password']);

    $config = [];

    $config['slim'] = [
        'settings' => [
            'determineRouteBeforeAppMiddleware' => true,
            'displayErrorDetails' => true,
            'addContentLengthHeader' => false,
            'db' => [
                'driver' => 'mysql',
                'host' =>  $_POST['db_host'],
                'port' =>  $_POST['db_port'],
                'database' => $_POST['db_db'],
                'username' => $_POST['db_user'],
                'password' => $_POST['db_password'],
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ],
        ],
    ];

    $config['ips'] = [
        'base_url' => $_POST['ipb_baseURL'],
        'master_url' => $_POST['ipb_baseURL'] . 'applications/core/interface/ipsconnect/ipsconnect.php',
        'master_key' => $_POST['ipb_masterKEY'],
        'api_key' => $_POST['ipb_apiKEY'],
        'allowedGroups' => [],
    ];

    try {
        $connection->query('CREATE TABLE IF NOT EXISTS `cw_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `connect_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `primaryGroup` text DEFAULT NULL,
  `secondaryGroups` text DEFAULT NULL,
  `profilePicture` text DEFAULT NULL,
  `profileUrl` text DEFAULT NULL,
  `pid` varchar(64) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`name`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `connect_id` (`connect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;');

        $connection->query('CREATE TABLE IF NOT EXISTS `cw_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(64) NOT NULL DEFAULT \'0\',
  `group_id` int(11) NOT NULL,
  `is_superUser` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_players` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_player` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_vehicles` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_vehicle` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_logs` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_player_civ_lic` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_player_cop_lic` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_player_ems_lic` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_player_notes` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_player_edit_log` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_player_vehicles` tinyint(1) NOT NULL DEFAULT 0,
  `can_compensate` tinyint(1) NOT NULL DEFAULT 0,
  `can_blacklist` tinyint(1) NOT NULL DEFAULT 0,
  `can_add_note` tinyint(1) NOT NULL DEFAULT 0,
  `can_delete_note` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_cash` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_bank` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_donator` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_jailed` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_cop_rank` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_cop_lic` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_ems_rank` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_ems_lic` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_civ_lic` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_admin_rank` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_vehicle` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;');

        $connection->query('CREATE TABLE IF NOT EXISTS `cw_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` enum(\'0\',\'1\',\'2\') NOT NULL DEFAULT \'0\',
  `message` text NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;');

        $connection->query('CREATE TABLE IF NOT EXISTS `cw_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` enum(\'0\',\'1\',\'2\',\'3\') NOT NULL DEFAULT \'0\',
  `message` text NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `forum_id` int(11) DEFAULT NULL,
  `old_id` int(11) DEFAULT NULL,
  `forum_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2836 DEFAULT CHARSET=utf8;');
    } catch (PDOException $ex) {
        die("Error: ". $ex->getMessage());
    }

    file_put_contents(__DIR__. '/../config/config.php', '<?php return '.var_export($config, true).';');
    $connection = null;

    //TODO: Check if file was written.

    die('CyberWorks Installed, Please delete this file (installer.php)');
}

include __DIR__ . '/../resources/views/installView.php';
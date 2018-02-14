<?php

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

    function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    $connection = checkConnection($_POST['db_host'], $_POST['db_port'], $_POST['db_db'], $_POST['db_user'], $_POST['db_password']);

    $config = [];

    $config['slim'] = [
        'settings' => [
            'determineRouteBeforeAppMiddleware' => true,
            'displayErrorDetails' => false,
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

    $config['email']['host'] = $_POST['email_host'];
    $config['email']['port'] = $_POST['email_port'];
    $config['email']['encryption'] = $_POST['email_encryption'];
    $config['email']['domain'] = $_POST['email_domain'];
    $config['email']['username'] = $_POST['email_user'];
    $config['email']['password'] = $_POST['email_password'];

    $config['lang'] = $_POST['panel_lang'];

    $config['useIps'] = false;
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
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `primaryGroup` text DEFAULT NULL,
  `connect_id` int(11) DEFAULT NULL,
  `secondaryGroups` text DEFAULT NULL,
  `profilePicture` text DEFAULT NULL,
  `profileUrl` text DEFAULT NULL,
  `pid` varchar(64) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`name`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `connect_id` (`connect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

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
  `can_view_gangs` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_containers` tinyint(1) NOT NULL DEFAULT 0,
  `can_view_houses` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_container` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_house` tinyint(1) NOT NULL DEFAULT 0,
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
  `can_edit_gang` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_group_name` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_group_perms_player` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_group_perms_vehicle` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_group_perms_settings` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_group_perms_gang` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_group_perms` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_group_ips_id` tinyint(1) NOT NULL DEFAULT 0,
  `can_make_groups` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_users` tinyint(1) NOT NULL DEFAULT 0,
  `can_add_user` tinyint(1) NOT NULL DEFAULT 0,
  `can_del_user` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_group_perms_container` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_group_perms_house` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

        $connection->query('CREATE TABLE IF NOT EXISTS `cw_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` enum(\'0\',\'1\',\'2\',\'3\',\'4\') NOT NULL DEFAULT \'0\',
  `message` text NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `container_id` int(11) DEFAULT NULL,
  `gang_id` int(11) DEFAULT NULL,
  `house_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

        $connection->query('INSERT INTO `cw_permissions` (`id`, `group_name`, `group_id`, `is_superUser`, `can_view_players`, `can_view_player`, `can_view_vehicles`, `can_view_vehicle`, `can_view_logs`, `can_view_player_civ_lic`, `can_view_player_cop_lic`, `can_view_player_ems_lic`, `can_view_player_notes`, `can_view_player_edit_log`, `can_view_player_vehicles`, `can_view_gangs`, `can_view_containers`, `can_view_houses`, `can_edit_container`, `can_edit_house`, `can_compensate`, `can_blacklist`, `can_add_note`, `can_delete_note`, `can_edit_cash`, `can_edit_bank`, `can_edit_donator`, `can_edit_jailed`, `can_edit_cop_rank`, `can_edit_cop_lic`, `can_edit_ems_rank`, `can_edit_ems_lic`, `can_edit_civ_lic`, `can_edit_admin_rank`, `can_edit_vehicle`, `can_edit_gang`, `can_edit_group_name`, `can_edit_group_perms_player`, `can_edit_group_perms_vehicle`, `can_edit_group_perms_settings`, `can_edit_group_perms_gang`, `can_edit_group_perms`, `can_edit_group_ips_id`, `can_make_groups`, `can_edit_users`, `can_add_user`, `can_del_user`, `can_edit_group_perms_container`, `can_edit_group_perms_house`) VALUES
	(1, \'Admin\', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1);');

        $query = $connection->prepare("INSERT INTO `cw_users` (`name`, `password`, `email`, `profilePicture`, `primaryGroup`, `created_at`) VALUES (:username, :password, :email, :profilePicture, '{\"id\":\"1\"}', NOW())");
        $query->bindParam(':username', $_POST['admin_user']);
        $query->bindParam(':email', $_POST['admin_email']);
        $query->bindParam(':password', password_hash($_POST['admin_password'], PASSWORD_DEFAULT));
        $query->bindParam(':profilePicture', get_gravatar($_POST['admin_email']));
        $query->execute();

    } catch (PDOException $ex) {
        die("Error: ". $ex->getMessage());
    }

    $written = file_put_contents(__DIR__. '/../config/config.php', '<?php return '.var_export($config, true).';');
    if ($written === false) {
        die('chmod 777 the Config Dir & Log Dir');
    }

    $connection = null;

    die('CyberWorks Installed, Please delete this file (installer.php)');
}

include __DIR__ . '/../resources/views/installView.php';

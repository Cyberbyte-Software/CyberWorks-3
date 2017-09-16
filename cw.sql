-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.2.7-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table life.cw_logs
CREATE TABLE IF NOT EXISTS `cw_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table life.cw_notes
CREATE TABLE IF NOT EXISTS `cw_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` enum('0','1','2') NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table life.cw_permissions
CREATE TABLE IF NOT EXISTS `cw_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(64) NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table life.cw_users
CREATE TABLE IF NOT EXISTS `cw_users` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 20/07/2017
 * Time: 14:33
     CREATE TABLE IF NOT EXISTS `cw_whitelist` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `player_id` varchar(50) NOT NULL,
        `player_guid` varchar(50) NOT NULL,
        `deleted_at` timestamp DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `id` (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
 */

namespace CyberWorks\Life\Models;

use Illuminate\Database\Eloquent\Model;

class Whitelist extends Model
{
    protected $table = 'cw_whitelist';

    protected $primaryKey = 'player_id';

    protected $fillable = [
        'player_id',
        'player_guid'
    ];
}
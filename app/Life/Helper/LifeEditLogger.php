<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 29/06/2017
 * Time: 14:36
 */

namespace CyberWorks\Life\Helper;

use CyberWorks\Core\Models\Log;

class LifeEditLogger
{
    public function logEdit($id, $type, $message) {
        $entry = new Log();
        $entry->user_id = $_SESSION['user_id'];
        $entry->message = $message;

        switch ($type) {
            case 0:
                $entry->player_id = $id;
                $entry->type = '0';
                break;
            case 1:
                $entry->vehicle_id = $id;
                $entry->type = '1';
                break;
            case 2:
                $entry->gang_id = $id;
                $entry->type = '2';
                break;
            case 3:
                $entry->container_id = $id;
                $entry->type = '3';
                break;
            case 4:
                $entry->house_id = $id;
                $entry->type = '4';
                break;
        }

        $entry->save();
    }
}
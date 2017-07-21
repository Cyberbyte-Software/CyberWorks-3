<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 29/06/2017
 * Time: 14:36
 */

namespace CyberWorks\Life\Helper;

use CyberWorks\Core\Models\Log;
use CyberWorks\Core\Models\ForumAccountLog;
use CyberWorks\Extra\Models\OldMemberLog;

class EditLogger
{
    public function logPlayerEdit($message, $playerID)
    {
        $log = new Log();
        $log->user_id = $_SESSION['user_id'];
        $log->player_id = $playerID;
        $log->message = $message;
        $log->type = '0';

        $log->save();
    }

    public function logVehicleEdit($message, $vehID)
    {
        $log = new Log();
        $log->user_id = $_SESSION['user_id'];
        $log->vehicle_id = $vehID;
        $log->message = $message;
        $log->type = '1';

        $log->save();
    }
}
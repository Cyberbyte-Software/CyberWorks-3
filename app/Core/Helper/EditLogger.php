<?php

namespace CyberWorks\Core\Helper;

use CyberWorks\Core\Models\Log;

class EditLogger
{
    public function logEdit($type, $message) {
        $entry = new Log();
        $entry->user_id = $_SESSION['user_id'];
        $entry->message = $message;
        $entry->type = $type;

        $entry->save();
    }
}
<?php

namespace CyberWorks\Core\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use CyberWorks\Core\Models\User;

class EmailTaken extends AbstractRule
{
    public function validate($input)
    {
        return User::where('email', $input)->count() == 1;
    }
}
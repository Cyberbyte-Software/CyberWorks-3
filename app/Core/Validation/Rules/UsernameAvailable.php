<?php

namespace CyberWorks\Core\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use CyberWorks\Core\Models\User;

class UsernameAvailable extends AbstractRule
{
    public function validate($input)
    {
        return User::where('name', $input)->count() == 0;
    }
}
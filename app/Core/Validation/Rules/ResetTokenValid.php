<?php

namespace CyberWorks\Core\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use CyberWorks\Core\Models\User;

class ResetTokenValid extends AbstractRule
{
    public function validate($input)
    {
        return User::where('password_reset_token', $input)->count() == 1;
    }
}
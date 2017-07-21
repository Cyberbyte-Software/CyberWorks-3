<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 13:58
 */

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
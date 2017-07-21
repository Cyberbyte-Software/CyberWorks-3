<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 14:15
 */

namespace CyberWorks\Core\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use CyberWorks\Core\Models\User;

class UsernameAvailable extends AbstractRule
{
    public function validate($input)
    {
        return User::where('username', $input)->count() == 0;
    }
}
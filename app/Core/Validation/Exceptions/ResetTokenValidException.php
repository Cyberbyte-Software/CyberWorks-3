<?php
/**
 * Created by PhpStorm.
 * User: Cameron Chilton
 * Date: 14/06/2017
 * Time: 14:11
 */

namespace CyberWorks\Core\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class ResetTokenValidException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
          self::STANDARD =>  'The Reset Token Is Not Valid',
        ],
    ];
}
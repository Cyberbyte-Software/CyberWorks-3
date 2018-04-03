<?php

namespace CyberWorks\Core\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class EmailTakenException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
          self::STANDARD =>  'The Email Address Is Not Valid',
        ],
    ];
}
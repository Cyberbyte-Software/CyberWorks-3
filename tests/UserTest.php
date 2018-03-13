<?php

use CyberWorks\Core\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsCameron()
    {
        $user = User::find(1);

        $this->assertEquals("cameron", $user->name);
    }
}
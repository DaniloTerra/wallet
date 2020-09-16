<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\User
 */
final class UserTest extends Unit
{
    /**
     * @covers ::foo
     */
    public function testFoo()
    {
        $user = new User();

        $result = $user->foo();

        static::assertEquals('bar', $result);
    }
}

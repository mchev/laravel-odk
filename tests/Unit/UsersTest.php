<?php

namespace Mchev\LaravelOdk\Tests;

use Mchev\LaravelOdk\OdkCentral;

class UsersTest extends TestCase
{

    /**
     * Test if can get users list.
     *
     * @return void
     */
    public function test_can_get_users()
    {
        $users = (new OdkCentral())->users()->get();

        $this->assertNotNull($users);
    }

    /**
     * Test if can get a user by id.
     *
     * @return void
     */
    public function test_can_get_user()
    {
        $userId = 115;

        $user = (new OdkCentral())->users(115)->get();

        $this->assertEquals($user->id, $userId);
    }
}

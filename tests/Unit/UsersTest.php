<?php

namespace Mchev\LaravelOdk\Tests;

use Mchev\LaravelOdk\Facades\OdkCentral;

class UsersTest extends TestCase
{
    public function test_can_get_users_list()
    {
        $users = OdkCentral::users()->get();
        $this->assertNotNull($users);
    }

    public function test_can_get_current_user()
    {
        $user = OdkCentral::users()->current();
        $this->assertNotNull($user);
    }

    public function test_can_create_and_delete_user()
    {
        $email = 'test.user@example.com';

        $user = OdkCentral::users()->create([
            'email' => $email,
            'password' => 'password123',
        ]);

        $this->assertNotNull($user);
        $this->assertEquals($email, $user->email);

        $result = OdkCentral::users($user->id)->delete();
        $this->assertTrue($result !== false);
    }

    public function test_can_update_user()
    {
        $users = OdkCentral::users()->get();
        $user = $users->first();

        $newName = 'Updated Name';
        $updated = OdkCentral::users($user->id)->update([
            'displayName' => $newName,
        ]);

        $this->assertEquals($newName, $updated->displayName);
    }
}

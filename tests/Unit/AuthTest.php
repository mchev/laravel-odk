<?php

namespace Mchev\LaravelOdk\Tests;

use Mchev\LaravelOdk\OdkCentralAuth;

class AuthTest extends TestCase
{
    protected OdkCentralAuth $auth;

    protected function setUp(): void
    {
        parent::setUp();
        $this->auth = new OdkCentralAuth;
    }

    public function test_can_generate_access_token()
    {
        $token = $this->auth->getAccessToken();
        $this->assertNotNull($token);
        $this->assertIsString($token);
    }

    public function test_can_destroy_access_token()
    {
        $result = $this->auth->destroyAccessToken();
        $this->assertTrue($result !== false);
    }

    public function test_token_is_cached()
    {
        $firstToken = $this->auth->getAccessToken();
        $secondToken = $this->auth->getAccessToken();
        $this->assertEquals($firstToken, $secondToken);
    }
}

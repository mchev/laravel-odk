<?php

namespace Mchev\LaravelOdk\Tests;

use Mchev\LaravelOdk\OdkCentral;

class FormsTest extends TestCase
{
    /**
     * Test if can get projects list.
     *
     * @return void
     */
    public function test_can_get_projects()
    {
        $projects = (new OdkCentral())->projects()->get();
        $this->assertNotNull($projects);
    }

    /**
     * Test if can get forms list.
     *
     * @return void
     */
    public function test_can_get_forms()
    {
        $projects = (new OdkCentral())->projects()->get();
        $forms = (new OdkCentral())->projects($projects->first()->id)->forms()->get();
        $this->assertNotNull($forms);
    }
}

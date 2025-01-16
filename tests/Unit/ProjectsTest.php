<?php

namespace Mchev\LaravelOdk\Tests;

use Mchev\LaravelOdk\Facades\OdkCentral;

class ProjectsTest extends TestCase
{
    protected $testProject;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test project
        $this->testProject = OdkCentral::projects()->create([
            'name' => 'Test Project '.time(),
        ]);
    }

    protected function tearDown(): void
    {
        // Clean up
        if ($this->testProject) {
            OdkCentral::projects($this->testProject->id)->delete();
        }
        parent::tearDown();
    }

    public function test_can_get_projects()
    {
        $projects = OdkCentral::projects()->get();
        $this->assertNotNull($projects);
    }

    public function test_can_create_project()
    {
        $this->assertNotNull($this->testProject);
        $this->assertIsString($this->testProject->name);
    }

    public function test_can_update_project()
    {
        $newName = 'Updated Project Name';
        $updated = OdkCentral::projects($this->testProject->id)->update([
            'name' => $newName,
        ]);

        $this->assertEquals($newName, $updated->name);
    }

    public function test_can_get_project_details()
    {
        $project = OdkCentral::projects($this->testProject->id)->get();
        $this->assertNotNull($project);
        $this->assertEquals($this->testProject->id, $project->id);
    }
}

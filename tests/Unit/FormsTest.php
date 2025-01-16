<?php

namespace Mchev\LaravelOdk\Tests;

use Illuminate\Http\UploadedFile;
use Mchev\LaravelOdk\Facades\OdkCentral;

class FormsTest extends TestCase
{
    protected $testProject;

    protected $testForm;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test project
        $this->testProject = OdkCentral::projects()->create([
            'name' => 'Test Project '.time(),
        ]);

        // Create a test XForm file
        $xmlContent = '<?xml version="1.0"?>
            <h:html xmlns="http://www.w3.org/2002/xforms">
                <!-- Basic XForm content -->
            </h:html>';

        $file = UploadedFile::fake()->createWithContent(
            'test_form.xml',
            $xmlContent
        );

        // Create a test form
        $this->testForm = OdkCentral::projects($this->testProject->id)
            ->forms()
            ->create($file, true);
    }

    protected function tearDown(): void
    {
        // Clean up
        if ($this->testForm) {
            OdkCentral::projects($this->testProject->id)
                ->forms($this->testForm->xmlFormId)
                ->delete();
        }
        if ($this->testProject) {
            OdkCentral::projects($this->testProject->id)->delete();
        }
        parent::tearDown();
    }

    public function test_can_get_forms()
    {
        $forms = OdkCentral::projects($this->testProject->id)->forms()->get();
        $this->assertNotNull($forms);
    }

    public function test_can_get_form_details()
    {
        $form = OdkCentral::projects($this->testProject->id)
            ->forms($this->testForm->xmlFormId)
            ->get();

        $this->assertNotNull($form);
        $this->assertEquals($this->testForm->xmlFormId, $form->xmlFormId);
    }

    public function test_can_get_form_fields()
    {
        $fields = OdkCentral::projects($this->testProject->id)
            ->forms($this->testForm->xmlFormId)
            ->fields()
            ->get();

        $this->assertNotNull($fields);
    }
}

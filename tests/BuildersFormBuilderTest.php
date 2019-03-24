<?php
namespace AppCompass\Tests;

use AppCompass\Builders\FormBuilder;

class BuildersFormBuilderTest extends TestCase
{
    /**
     * Check that the multiply method returns correct result
     * @return void
     */
    public function testCreateFormBuilder()
    {
        $form_name = 'test_form';
        $formBuilder = FormBuilder::new($form_name);

        $this->assertSame($form_name, $formBuilder->getName());
    }
}

<?php
namespace AppCompass\FormBuilder\Tests;

use AppCompass\FormBuilder\Builders\FormBuilder;

class BuildersFormBuilderTest extends TestCase
{
    /**
     * Check that the multiply method returns correct result
     * @return void
     */
    public function testCreateFormBuilder()
    {
        $form_name = $this->faker->slug;
        $formBuilder = FormBuilder::new($form_name);

        $this->assertSame($form_name, $formBuilder->getName());
    }
}

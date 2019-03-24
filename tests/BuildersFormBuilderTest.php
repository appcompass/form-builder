<?php
namespace AppCompass\FormBuilder\Tests;

use AppCompass\FormBuilder\Builders\FormBuilder;
use AppCompass\FormBuilder\Models\Form;
use AppCompass\FormBuilder\Models\Field;
use AppCompass\FormBuilder\Models\FieldTypes\StringType;

class BuildersFormBuilderTest extends TestCase
{
    public function testCreateFormBuilder()
    {
        $formName = $this->faker->slug;
        $formBuilder = FormBuilder::new($formName);

        $this->assertSame($formName, $formBuilder->getName());
    }

    public function testEditFormByName()
    {
        $formName = $this->faker->slug;

        $form = Form::create([
            'name' => $formName,
        ]);
        $formBuilderByModel = FormBuilder::edit($form);

        $this->assertSame($formName, $formBuilderByModel->getName());

        $formBuilderByName = FormBuilder::edit($formName);

        $this->assertSame($formName, $formBuilderByName->getName());

        $formBuilderById = FormBuilder::edit($form->id);

        $this->assertSame($formName, $formBuilderById->getName());
    }

    public function testSetOwner()
    {
        $anotherForm = Form::create([
            'name' => $this->faker->slug,
        ]);

        $owner = StringType::make(
            $this->faker->name,
            $this->faker->slug,
            $anotherForm
        )->field;

        $formBuilder = FormBuilder::new($this->faker->slug);

        $formBuilder->setOwner($owner);

        $this->assertSame($owner, $formBuilder->getForm()->formable);
    }
}

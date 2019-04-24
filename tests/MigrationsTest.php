<?php
namespace AppCompass\FormBuilder\Tests;

use Illuminate\Support\Facades\Schema;

class MigrationsTest extends TestCase
{
    public function testMigrations()
    {
        // TODO: use this when the change merged to make this method public is released.
        // dd(Schema::getAllTables());
        $fieldtypes = Schema::getColumnListing('fieldtypes');
        $this->assertEquals([
            'name',
            'template'
        ], $fieldtypes);

        $forms = Schema::getColumnListing('forms');
        $this->assertEquals([
            'id',
            'name',
            'config',
            'editor',
            'handler',
            'formable_type',
            'formable_id',
            'created_at',
            'updated_at'
        ], $forms);

        $fields = Schema::getColumnListing('fields');
        $this->assertEquals([
            'id',
            'name',
            'label',
            'type',
            'to_list',
            'to_edit',
            'help',
            'config',
            'content',
            'validation',
            'parent_id',
            'form_id',
            'dynamic'
        ], $fields);


        $field_sources = Schema::getColumnListing('field_sources');
        $this->assertEquals([
            'id',
            'sourceable_type',
            'sourceable_id',
            'field_id',
            'related_field',
            'data',
            'criteria'
        ], $field_sources);
    }

}

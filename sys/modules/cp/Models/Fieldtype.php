<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Storage;
use P3in\Models\Types\BaseField;

class Fieldtype extends Model
{
    // public $table = 'fieldtypes';

    public $fillable = [
        'name',
        'template'
    ];

    protected $primaryKey = 'name';

    public $incrementing = false;

    public $timestamps = false;

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public static function make(BaseField $field_type)
    {
        $instance = Fieldtype::firstOrCreate([
            'name' => $field_type->getName(),
            'template' => $field_type->getTemplate()
        ]);

        // maintain components library

        Fieldtype::renderComponents();

        return $instance->name;
    }

    // @TODO: we have a view template that we can abstract and use for this currently in websites module.
    private static function renderComponents()
    {
        $disk = Storage::diskByName('cp_components');

        $importer_block = [];
        $exporter_block = [];

        // foreach ($manager->listContents('source://', true) as $file) {
        foreach (Fieldtype::all() as $component) {
            $importer_block[] = "import {$component->name}Type from './FormBuilder/$component->name'";
            $exporter_block[] = "export var $component->name = {$component->name}Type";
        }

        $content = implode("\n", array_merge($importer_block, $exporter_block))."\n"; // . "\n" . implode("\n", $exporter_block) . "\n";

        $disk->put('Components.js', $content);
    }
}

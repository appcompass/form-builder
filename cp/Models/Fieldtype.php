<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Types\BaseField;
use League\Flysystem\MountManager;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Adapter\Local as LocalAdapter;

class Fieldtype extends Model
{
    const PUBLIC_COMPONENTS_FOLDER = /* base_path() */ '/../cp/src/components/FormBuilder';
    const COMPONENTS_LIB_PATH = /* base_path */ '/../cp/src/components';

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

    private static function renderComponents()
    {
        $manager = new MountManager([
            // @TODO in case we wanna get rid of the table and work on a 100% file based instance
            // 'source' => new Flysystem(new LocalAdapter(base_path() . self::PUBLIC_COMPONENTS_FOLDER)),
            'to' => new Flysystem(new LocalAdapter(base_path() . self::COMPONENTS_LIB_PATH)),
        ]);

        $importer_block = [];
        $exporter_block = [];

        // foreach ($manager->listContents('source://', true) as $file) {
        foreach (Fieldtype::all() as $component) {
            $importer_block[] = "import {$component->name}Type from './FormBuilder/$component->name'";
            $exporter_block[] = "export var $component->name = {$component->name}Type";
        }

        $content = implode("\n", array_merge($importer_block, $exporter_block)); // . "\n" . implode("\n", $exporter_block) . "\n";

        $manager->put('to://' . 'Components.js', $content . "\n");
    }
}

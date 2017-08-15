<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\FieldTypes\BaseField;

class Fieldtype extends Model
{

    // public $table = 'fieldtypes';

    public $fillable = [
        'name',
        'template',
    ];

    protected $primaryKey = 'name';

    public $incrementing = false;

    public $timestamps = false;

    public function fields()
    {
        return $this->hasMany(Field::class, 'type', 'name');
    }

    public static function make(BaseField $field_type)
    {
        $instance = Fieldtype::firstOrCreate([
            'name'     => $field_type->getName(),
            'template' => $field_type->getTemplate(),
        ]);

        return $instance->name;
    }
}

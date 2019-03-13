<?php

namespace AppCompass\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use AppCompass\Traits\HasDynamicContent;

class Field extends Model
{
    use HasDynamicContent {
        dynamic as dynamicTrait;
    }

    protected static $unguarded = true;

//    public $fillable = [
//        'name',
//        'label',
//        'type',
//        'config',
//        'validation',
//        'dynamic',
//        'form_id',
//        'help',
//    ];

    protected $casts = [
        'config' => 'object',
    ];


    protected $hidden = [];

    protected $appends = [];

    public $timestamps = false;

    /**
     * override boot method
     *
     * @NOTE remember Field::withoutGlobalScope('order')->get();
     * @TODO we can probably get rid of this i added the scope for the sake of it -f
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }

    /**
     * The Form
     *
     * @return     belongsToMany
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function type()
    {
        return $this->belongsTo(Fieldtype::class, 'name', 'type');
    }

    /**
     * The Parent
     *
     * @return     belongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Field::class, 'parent_id');
    }

    /**
     * The Fields
     *
     * @return     hasMany
     */
    public function fields()
    {
        return $this->hasMany(Field::class, 'parent_id');
    }

    /**
     * Field Chiildren (sub-form)
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function children()
    {
        return $this->hasMany(Field::class, 'parent_id');
    }

    /**
     * { function_description }
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function source()
    {
        return $this->hasOne(FieldSource::class);
    }

    // usage:  $model->getConfig('something.deep.inside.config')
    public function getConfig($key)
    {
        // array_get is what we need but only works with arrays.
        $conf = json_decode(json_encode($this->config ?: []), true);

        return array_get($conf, $key, null);
    }

    public function setConfig($key, $val = null)
    {
        if (gettype($key) == 'string') {
            $key = 'config->' . $key;
        } else {
            $val = $key;
            $key = 'config';
        }

        $key = str_replace('.', '->', $key);

        $this->update([$key => $val]);

        return $this;
    }

    // usage: ModelWithThisTrait::byConfig('field->sub_field->other_field', 'value of other_field')->get()
    public function scopeByConfig($query, $key, $operator = null, $value = null, $boolean = 'and')
    {
        $key = str_replace('.', '->', $key);

        return $query->where("config->$key", $operator, $value, $boolean);
    }


    /**
     * Set the
     */
    public function dynamic($what_to_link, \Closure $callback = null)
    {
        $this->update(['dynamic' => true]);

        $this->dynamicTrait($what_to_link, $callback);

        return $this;
    }

    /**
     * { function_description }
     *
     * @param      boolean $nullable The nullable
     */
    public function nullable($nullable = true)
    {
        $this->setConfig('nullable', $nullable);
    }

    /**
     * Make sure config doesn't return empty
     *
     * @return     array  The configuration attribute.
     */
    public function getConfigAttribute($value)
    {
        return json_decode($value) ?? [];
    }

    /**
     * Sets the parent.
     *
     * @param      Field $field The field
     */
    public function setParent(Field $field)
    {
        $this->parent()->associate($field)->save();
    }

    /*
     * is the field gonna be visible on edit mode?
     */
    public function edit($show = true)
    {
        $this->update(['to_edit' => $show]);

        return $this;
    }

    /*
     * is the field gonna be visible on list mode?
     */
    public function list($show = true)
    {
        $this->update(['to_list' => $show]);

        return $this;
    }

    /**
     * Required
     */
    public function required($required = true)
    {
        $attrs = $this->getAttributes();

        $exploded = isset($attrs['validation']) ? explode(' | ', $attrs['validation']) : [];

        if (isset($exploded['required'])) {
            unset($exploded['required']);
        }

        $exploded[] = $required ? 'required' : null;

        return $this->validation($exploded);
    }

    /**
     * Repeatable
     */
    public function repeatable($repeatable = true)
    {
        $this->setConfig('repeatable', $repeatable);

        return $this;
    }

    public function multiple($multiple = true)
    {
        $this->setConfig('multiple', $multiple);

        return $this;
    }

    /**
     * Keys
     */
    public function keys()
    {
        // @NOTE rethink this, we are using dynamic to initialize Config fields
        // setting the allowed keys allows adding
    }

    /**
     *  Sortable
     */
    public function sortable($sortable = true)
    {
        $this->setConfig('sortable', $sortable);

        return $this;
    }

    /**
     *  Searchable
     */
    public function searchable($searchable = true)
    {
        $this->setConfig('searchable', $searchable);

        return $this;
    }

    /**
     * Set helper message
     *
     * @param      <type>  $help   The help
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function help($help = null)
    {
        $this->update(['help' => $help]);

        return $this;
    }

    /**
     *  Validation
     */
    public function validation($validation)
    {
        if (is_array($validation)) {
            $validation = implode('|', $validation);
        }

        $this->update(['validation' => $validation]);

        return $this;
    }

    /**
     * Gets the data attribute.
     *
     * @return     <type>  The data attribute.
     */
    public function getDataAttribute()
    {
        return $this->source;
    }
}

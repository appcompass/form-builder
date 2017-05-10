<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\FieldSource;
use P3in\Models\Scopes\OrderScope;
use P3in\Traits\HasDynamicContent;
use P3in\Traits\HasJsonConfigFieldTrait;

class Field extends Model
{
    use HasDynamicContent {
        dynamic as dynamicTrait;
    }
    use HasJsonConfigFieldTrait;

    public $fillable = [
        'name',
        'label',
        'type',
        'config',
        'validation',
        'dynamic',
        'form_id',
        'help'
    ];

    protected $casts = [
        'config' => 'object',
    ];

    protected $hidden = [];

    protected $appends = [];

    public $timestamps = false;

    /**
     * override boot method
     * @NOTE remember Field::withoutGlobalScope(OrderScope::class)->get();
     * @TODO we can probably get rid of this i added the scope for the sake of it -f
     */
    protected static function boot()
    {
        static::addGlobalScope(new OrderScope('id', 'asc'));

        parent::boot();
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
        return $this->morphOne(FieldSource::class, 'linked');
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
     * @param      boolean  $nullable  The nullable
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
     * @param      Field  $field  The field
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

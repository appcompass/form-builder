<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\FieldSource;

class Field extends Model
{
    protected $fillable = [
        'name',
        'label',
        'type',
        'to_list',
        'to_edit',
        'required',
        'repeatable',
        'sortable',
        'dynamic'
    ];

    protected $hidden = [];

    public $timestamps = false; // we don't need ts on fields

    /**
     * override boot method
     * @NOTE remember Field::withoutGlobalScope(OrderScope::class)->get();
     * @TODO we can probably get rid of this i added the scope for the sake of it -f
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderScope('id', 'asc'));
    }

    /**
     * The Form
     *
     * @return     belongsToMany
     */
    public function form()
    {
        // return $this->belongsToMany(Form::class);
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
        // return $this->hasOne(FieldSource::class);
    }

    /**
     * { function_description }
     */
    public function dynamic($what_to_link, \Closure $callback = null)
    {
        $this->update(['dynamic' => true]);

        $field_source = $this->addSource($what_to_link);

        if ($callback) {

            $callback($field_source);

        }

        return $this;
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
     *  Required
     */
    public function required($required = true)
    {
        $this->update(['required' => $required]);

        return $this;
    }

    /**
     * Repeatable
     */
    public function repeatable($repeatable = true)
    {
        $this->update(['repeatable' => $repeatable]);

        return $this;
    }

    /**
     *  Sortable
     */
    public function sortable($sortable = true)
    {
        $this->update(['sortable' => $sortable]);

        return $this;
    }

    /**
     *  Searchable
     */
    public function searchable($searchable = true)
    {
        $this->update(['searchable' => $searchable]);

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

    // public function addSource($class_name, array $data = null, array $criteria = null)
    public function addSource($source)
    {

        // make sure we keep stuff clean, we never want more than one source for a field
        FieldSource::whereLinkedId($this->id)->whereLinkedType(get_class($this))->delete();

        // generate a fieldSource
        $field_source = FieldSource::create([
            // if passed an array we assume we'd want to store data
            'data' => is_array($source) ? $source : null,
            'criteria' => [] // generate default criteria
        ]);

        if (is_string($source)) {

            $field_source->sourceable_type = $source;

        } elseif ($source instanceof Model) {

            $field_source->sourceable_type = get_class($source);

            $key = $source->getKeyName();

            if (isset($source->{$key}) && !is_null($source->{$key})) {

                $field_source->sourceable_id = $source->{$key};

            }

        }

        // @TODO check if ->save() saves the model, it should
        $this->source()->save($field_source);

        $field_source->save();

        return $field_source;
    }

    public function getDataAttribute()
    {
        return $this->source;
    }

}

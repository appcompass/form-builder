<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\FieldSource;
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
        'dynamic'
    ];

    protected $casts = [
        'config' => 'object',
    ];
    protected $hidden = [];

    protected $appends = [
        'to_list',
        'to_edit',
        'sortable',
        'searchable',
        'repeatable',
    ];

    // @TODO: would be nice to know when fields were added/changed?
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

    // used with HasJsonConfigFieldTrait
    public function getAsFirstLevelConfig() {
        // if appends changes to add real fields, we then have to use the actual array here.
        return $this->appends;
        // return [
        //     'to_list',
        //     'to_edit',
        //     'sortable',
        //     'searchable',
        //     'repeatable',
        // ];
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
    }

    /**
     * { function_description }
     */
    public function dynamic($what_to_link, \Closure $callback = null)
    {
        $this->update(['dynamic' => true]);

        $this->dynamicTrait($what_to_link, $callback);

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
        $this->setConfig('to_edit', $show);

        return $this;
    }

    /*
     * is the field gonna be visible on list mode?
     */
    public function list($show = true)
    {
        $this->setConfig('to_list', $show);

        return $this;
    }

    /**
     * Repeatable
     */
    public function repeatable($repeatable = true)
    {
        $this->setConfig('repeatable', $repeatable);

        return $this;
    }

    // This is a repeatable field that you must specify the key for each item.
    // i.e. an associative array rather than indexed one.
    public function keyedRepeatable($keyedRepeatable = true)
    {
        $this->setConfig('keyed_repeatable', $keyedRepeatable);

        return $this;
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

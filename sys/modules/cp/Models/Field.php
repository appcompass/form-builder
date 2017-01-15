<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'name',
        'label',
        'type',
        'to_list',
        'to_edit',
        'validation',
        'required',
        'repeatable'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $with = [
        'fields'
    ];
    /**
     * override boot method
     * @NOTE remember Field::withoutGlobalScope(OrderScope::class)->get();
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderScope('id', 'asc'));
    }

    public function form()
    {
        return $this->belongsToMany(Form::class);
    }

    public function fieldType()
    {
        return $this->belongsTo(Fieldtype::class);
    }

    public function parent()
    {
        return $this->belongsTo(Field::class, 'parent_id');
    }

    public function fields()
    {
        return $this->hasMany(Field::class, 'parent_id');
    }

    // kill the repetition!
    private function saveAndReturn()
    {
        $this->save();

        return $this;
    }

    // is the field gonna be visible on edit mode?
    public function edit($show = true)
    {
        $this->to_edit = $show;

        return $this->saveAndReturn();
    }

    // the field visible on list mode?
    public function list($show = true)
    {
        $this->to_list = $show;

        return $this->saveAndReturn();
    }

    /**
     *
     */
    public function validation($validation)
    {
        $this->validation = $validation;

        return $this->saveAndReturn();
    }

    /**
     *
     */
    public function required($required = true)
    {
        $this->required = true;

        return $this->saveAndReturn();
    }

    public function repeatable($repeatable = true)
    {
        $this->repeatable = true;

        return $this->saveAndReturn();
    }
    /**
     *
     */
    public function sortable($sortable = true)
    {
        $this->sortable = $sortable;

        return $this->saveAndReturn();
    }

    /**
     *
     */
    public function searchable($searchable = true)
    {
        $this->searchable = $searchable;

        return $this->saveAndReturn();
    }
}

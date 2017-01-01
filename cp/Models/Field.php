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
        'required'
    ];

    protected $hidden = [
    //     'to_list',
    //     'to_edit',
    //     'pivot',
        'created_at',
        'updated_at'
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

    public function Form()
    {
        return $this->belongsToMany(Form::class);
    }

    public function fieldType()
    {
        return $this->belongsTo(Fieldtype::class);
    }

    // is the field gonna be visible on edit mode?
    public function edit($show = true)
    {
        $this->to_edit = $show;

        $this->save();

        return $this;
    }

    // the field visible on list mode?
    public function list($show = true)
    {
        $this->to_list = $show;

        $this->save();

        return $this;
    }

    /**
     *
     */
    public function validation($validation)
    {
        $this->validation = $validation;

        $this->save();

        return $this;
    }

    /**
     *
     */
    public function required($required = true)
    {
        $this->required = true;

        $this->save();

        return $this;
    }

    /**
     *
     */
    public function sortable($sortable = true)
    {
        $this->sortable = $sortable;

        $this->save();

        return $this;
    }

    /**
     *
     */
    public function searchable($searchable = true)
    {
        $this->searchable = $searchable;

        $this->save();

        return $this;
    }

}

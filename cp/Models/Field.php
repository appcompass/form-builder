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
        'to_edit'
    ];

    protected $hidden = [];

    protected $with = [
        'fields'
    ];

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
        return $this->belongsToMany(Form::class);
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
     *  Validation
     */
    public function validation($validation)
    {
        $this->update(['validation' => $validation]);

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
        $this->update(['required' => $repeatable]);

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

}

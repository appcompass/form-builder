<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Form extends Model
{
    protected $fillable = [
        'name',
        'resource'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $with = ['fields'];

    /**
     * Links to models
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function formable()
    {
        return $this->morphTo();
    }

    /**
     * Fields
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class);
    }

    /**
     * resources connected to the form
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Sets the owner.
     *
     * @param      \Illuminate\Database\Eloquent\Model  $owner  The owner
     *
     * @return     <type>                               ( description_of_the_return_value )
     */
    public function setOwner(Model $owner)
    {
        if (isset($owner->{$owner->getKeyName()})) {

            $this->formable_id = $owner->{$owner->getKeyName()};

        }

        $this->formable_type = get_class($owner);

        $this->save();

        return $this;
    }


    /**
     * like website.create or page.content
     *
     * @param      \Illuminate\Database\Eloquent\Builder  $query          The query
     * @param      <string>                               $resource_name  The resource name
     *
     * @return     \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByResource(Builder $query, $resource_name)
    {
        return $query->whereHas('resources', function (Builder $query) use ($resource_name) {
            return $query->where('resource', $resource_name);
        });
    }

    /**
     *
     */
    public function scopeToList(Builder $query)
    {
        if (isset($this->id)) {
            $query->where('id', $this->id);
        }

        return $this->filterBySub($query, 'fields', 'to_list', true);
    }

    /**
     *
     */
    public function scopeToEdit(Builder $query)
    {
        // we often wanna call that on an instanced model
        if (isset($this->id)) {
            $query->where('id', $this->id);
        }

        return $this->filterBySub($query, 'fields', 'to_edit', true);
    }

    /**
     * Sets the layout type for list view.
     *
     * @param      <type>  $type   The layout
     */
    public function setListLayout($list_layout)
    {
        $this->list_layout = $list_layout;

        if ($this->save()) {
            return $this;
        }
    }

    /**
     *
     */
    public function addField(Field $field)
    {
        return $this->fields()->attach($field);
    }

    /**
     *
     */
    private function filterBySub(Builder $query, $sub, $param, $val)
    {
        return $query->with([

            $sub => function ($query) use ($param, $val) {
                $query->where($param, $val);
            }
        ]);
    }
}

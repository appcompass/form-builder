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
        // @TODO look up the associate() equivalent, no time now
        return $this->update([
            'formable_id' => $owner->id,
            'formable_type' => get_class($owner)
        ]);
    }


    /**
     * like website.create or page.content
     *
     * @param      \Illuminate\Database\Eloquent\Builder  $query          The query
     * @param      <type>                                 $resource_name  The resource name
     *
     * @return     <type>                                 ( description_of_the_return_value )
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
        // we often wanna call that on an instenaced model
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

    /**
     *
     */
    public function setAlias($alias)
    {
        foreach ((array) $alias as $single) {
            $form_alias = new FormAlias(['alias' => $single]);

            $form_alias->form()->associate($this)->save();
        }

        return $this;
    }

    /**
     *
     */
    public function dropAlias($alias)
    {
        return FormAlias::whereAlias($alias)
            ->where('form_id', $this->id)
            ->firstOrFail()
            ->delete();
    }
}

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

    public function formable()
    {
        return $this->morphTo();
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class);
    }

    /**
     *
     */
    public function aliases()
    {
        return $this->hasMany(FormAlias::class);
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

        throw new \Exception("Unable to set ListLayout for this Form.");
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

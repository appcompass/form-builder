<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Form extends Model
{
    protected $fillable = [
        'name',
        'editor'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // protected $casts = [
    //     'view_types' => 'array',
    // ];

    protected $with = ['fields.source'];

    protected $appends = ['fieldsCount'];

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
        return $this->hasMany(Field::class);
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
     * Render form, build fields hierarchy
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function render($mode = null)
    {
        $form = $this->attributes;

        $fields = null;

        switch ($mode) {
            case 'list': //@TODO: Delete/rename, index is the resource to use.
            case 'index':
                $fields = $this->fields->where('to_list', true);
                break;
            case 'edit': //@TODO: Delete/rename, show is the resource to use.
            case 'show': //@TODO: show and update use the same set of fields.
            case 'update':
            case 'create': //@TODO: create and store use the same set of fields.
            case 'store':
            case 'destroy': //@TODO: add field(s) for validation on delete. for example, "hey this is a related field, first please move or delete xyz".
                $fields = $this->fields->where('to_edit', true);
                break;
            default:
                $fields = $this->fields;
                break;
        }

        $form['fields'] = $this->buildTree($fields);

        return $form;
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
        // if (isset($owner->{$owner->getKeyName()})) {
        //     $this->formable_id = $owner->{$owner->getKeyName()};
        // }

        // $this->formable_type = get_class($owner);
        $this->formable()->associate($owner);

        $this->save();

        return $this;
    }

    public function setViewTypes(array $types)
    {
        $this->update(['view_types' => $types]);

        return $this;
    }

    public function setCreateType(string $type)
    {
        $this->update(['create_type' => $type]);

        return $this;
    }

    public function setUpdateType(string $type)
    {
        $this->update(['update_type' => $type]);

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
     * Sets the editor
     *
     * @param      <type>  $editor  The editor
     *
     * @return     self    ( description_of_the_return_value )
     */
    public function editor($editor)
    {
        $this->editor = $editor;

        if ($this->save()) {
            return $this;
        }
    }

    /**
     *  Stores current Form as Field owner
     */
    public function addField(Field $field)
    {
        return $field->form()->save($this);
    }

    /**
     * Get form rules
     */
    public function rules()
    {
        $rules = [];

        // we only care about to_edit rules
        foreach ($this->fields()->where('to_edit', true)->get() as $field) {
            if (!is_null($field->validation)) {
                $rules[$this->getParentsChain($field)] = $field->validation;
            }
        }

        return $rules;
    }

    /**
     * Gets the fields count attribute.
     *
     * @return     <type>  The fields count attribute.
     */
    public function getFieldsCountAttribute()
    {
        return $this->fields->count();
    }

    /**
     * store
     *
     * @param      <type>  $content  The content
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function store($content)
    {
        return FormStorage::store($content, $this);
    }

    /**
     * Gets the dot separated field's parents chain.
     *
     * @param      Field   $field  The field
     *
     * @return     string  The parents chain.
     */
    private function getParentsChain(Field $field)
    {
        $parents = [];

        while (!is_null($field)) {
            $parents[] = $field->name;

            $field = $field->parent;
        }

        return implode('.', array_reverse($parents));
    }

    /**
     * Builds a menu tree recursively.
     *
     * @param      array   $items     The items
     * @param      <type>  $parent_id  The parent identifier
     *
     * @return     array   The tree.
     */
    private function buildTree(Collection &$items, $parent_id = null, $tree = null)
    {
        if (is_null($tree)) {
            $tree = [];
        }

        foreach ($items as &$node) {
            if ($node->parent_id === $parent_id) {
                $fields = $this->buildTree($items, $node->id);

                if (count($fields)) {
                    $node->fields = $fields;
                } else {
                    $node->fields = [];
                }

                // @TODO we return as array because we wanna trigger Field->source()
                $tree[] = $node->toArray();
            }
        }

        return $tree;
    }
}

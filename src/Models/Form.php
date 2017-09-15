<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use P3in\Traits\HasJsonConfigFieldTrait;

class Form extends Model
{

    use HasJsonConfigFieldTrait;

    //    protected $fillable = [
    //        'name',
    //        'editor',
    //    ];

    protected static $unguarded = true;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'config' => 'object',
        // 'view_types' => 'array',
    ];

    protected $with = ['fields.source'];

    protected $appends = ['fieldsCount'];

    //used to pass where filtering to the form->render() method.
    protected $render_where = [];

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
     * Sets the owner.
     *
     * @param      \Illuminate\Database\Eloquent\Model $owner The owner
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
        if ($handler = $this->handler()) {
            return $handler->handle($content);
        }

        //@TODO: fix all the other forms and then remove this.
        return FormStorage::store($content, $this);
    }

    public function handler()
    {
        if ($this->handler) {
            $class = $this->handler;
            return with(new $class($this));
        }
    }

    /**
     * Gets the dot separated field's parents chain.
     *
     * @param      Field $field The field
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
     * @param      array $items The items
     * @param      <type>  $parent_id  The parent identifier
     *
     * @return     array   The tree.
     */
    public function buildTree(Collection &$items, $parent_id = null, $tree = null)
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

    public function setRenderWhere(array $array)
    {
        $this->render_where = $array;
    }

    public function getRenderWhere()
    {
        return $this->render_where;
    }

    public function render()
    {
        $form = $this->attributes;

        $fields = $this->fields;

        if ($wheres = $this->getRenderWhere()) {
            foreach ($wheres as $key => $val) {
                $fields = $fields->where($key, $val);
            }
        }

        $form['fields'] = $this->buildTree($fields);

        return $form;
    }
}

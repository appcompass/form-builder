<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Component;
use P3in\Models\Page;

class PageComponentContent extends Model
{
    protected $table = 'page_component_content';

    protected $fillable = [
        'content',
        'columns',
        'order'
    ];

    protected $casts = [
        'content' => 'object'
    ];

    protected $with = ['children','component.form']; // for automatic recursion. I hate the component.form here btw so def refactoring.
    /**
     *
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     *
     */
    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * parent
     *
     * @return     BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * children
     *
     * @return     HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // /**
    //  *
    //  */
    // public function photos()
    // {
    //     return $this->morphMany(Photo::class, 'photoable');
    // }

    /**
     * Set the current section to a container type. It will fail if a page is
     * not previously associated with it though. (prob needs some refactoring)
     * @param int $columns
     * @param int $order
     * @return Model PageComponentContent
     */
    public function saveAsContainer(int $columns, int $order)
    {
        $container = Component::getContainer();

        $this->fill(['columns' => $columns, 'order' => $order]);

        $this->component()->associate($container);

        $this->save();

        return $this;
    }

    /**
     * Add a child container to a parent.
     * @param int $columns
     * @param int $order
     * @return Model PageComponentContent
     */
    public function addContainer(int $columns, int $order)
    {
        $container = Component::getContainer();

        return $this->addSection($container, $columns, $order);
    }

    /**
     * Add a section to a container.
     * @param Component $component
     * @param int $columns
     * @param int $order
     * @return Model PageComponentContent
     */
    public function addSection(Component $component, int $columns, int $order)
    {
        if ($this->isContainer()) {
            $child = new static(['columns' => $columns, 'order' => $order]);

            $child->component()->associate($component);

            $child->page()->associate($this->page);

            $this->children()->save($child);

            return $child;
        } else {
            throw new Exception('a Section can only be added to a Container.');
        }
    }

    public function saveContent($content)
    {
        $this->content = $content;
        $this->save();
        return $this;
    }

    public function isContainer()
    {
        return $this->component->type === 'container';
    }
}

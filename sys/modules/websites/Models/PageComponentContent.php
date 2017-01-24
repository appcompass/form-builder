<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Component;
use P3in\Models\Page;
use Exception;

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

    protected $with = [
        'children',
        'component'
    ];
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
     * Set the current section to a container type.
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

        return $this->addSection($container, $columns, $order, true);
    }

    /**
     * Add a section to a container.
     *
     * @param      Component  $component
     * @param      int        $columns
     * @param      int        $order
     * @param      boolean    $returnChild  The return child
     *
     * @throws     Exception  (description)
     *
     * @return     Model      PageComponentContent
     */
    public function addSection(Component $component, int $columns, int $order, $returnChild = false)
    {
        if ($this->isContainer()) {

            $child = new static(['columns' => $columns, 'order' => $order]);

            $child->component()->associate($component);

            $this->children()->save($child);

            if ($returnChild) {
                return $child;
            }

            return $this;

        } else {

            throw new Exception('a Section can only be added to a Container.');

        }
    }

    /**
     * Saves a content.
     *
     * @param      <type>  $content  The content
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function saveContent($content)
    {
        $this->content = $content;
        $this->save();
        return $this;
    }

    /**
     * Determines if container.
     *
     * @return     boolean  True if container, False otherwise.
     */
    public function isContainer()
    {
        return $this->component->type === 'container';
    }
}

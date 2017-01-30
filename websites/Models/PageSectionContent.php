<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Model;
use P3in\Models\Section;
use P3in\Models\Page;
use Exception;

class PageSectionContent extends Model
{
    protected $table = 'page_section_content';

    protected $fillable = [
        'config',
        'order',
        'content',
    ];

    protected $casts = [
        'config' => 'object',
        'content' => 'object',
    ];

    protected $with = [
        'children',
        'section',
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
    public function section()
    {
        return $this->belongsTo(Section::class);
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
     * @param int $order
     * @param array $config
     * @return Model PageSectionContent
     */
    public function saveAsContainer(int $order, array $config = null)
    {
        $container = Section::getContainer();

        $this->fill(['order' => $order, 'config' => $config]);

        $this->section()->associate($container);

        $this->save();

        return $this;
    }

    /**
     * Add a child container to a parent.
     * @param int $order
     * @param array $config
     * @return Model PageSectionContent
     */
    public function addContainer(int $order, array $config = null)
    {
        $container = Section::getContainer();

        return $this->addSection($container, $order, $config, true);
    }

    /**
     * Add a section to a container.
     *
     * @param      Section  $section
     * @param      int        $columns
     * @param      int        $order
     * @param      boolean    $returnChild  The return child
     *
     * @throws     Exception  (description)
     *
     * @return     Model      PageSectionContent
     */
    public function addSection(Section $section, int $order, array $config = null, $returnChild = false)
    {
        if ($this->isContainer()) {

            $child = new static(['order' => $order, 'config' => $config]);

            $child->section()->associate($section);

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
        return $this->section->type === 'container';
    }
}
